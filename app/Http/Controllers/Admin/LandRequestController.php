<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LandRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = LandRequest::query();

            // Global search
            $search = $request->input('search.value');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('applicant_name', 'like', "%{$search}%")
                        ->orWhere('national_id', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('phone_alt', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%");
                });
            }

            $total = LandRequest::count();
            $filtered = $query->count();

            // Ordering
            $columns = ['id','applicant_name','national_id','phone','phone_alt','notes','created_at'];
            $orderColIndex = (int)($request->input('order.0.column', 6));
            $orderDir = $request->input('order.0.dir', 'desc');
            $orderCol = $columns[$orderColIndex] ?? 'created_at';
            $query->orderBy($orderCol, $orderDir === 'asc' ? 'asc' : 'desc');

            // Pagination
            $start = (int)$request->input('start', 0);
            $length = (int)$request->input('length', 25);
            if ($length !== -1) {
                $query->skip($start)->take($length);
            }

            $data = $query->get()->map(function ($row) use ($start) {
                return [
                    'id' => $row->id,
                    'index' => null, // will be handled on client if needed
                    'applicant_name' => e($row->applicant_name),
                    'national_id' => e($row->national_id),
                    'phone' => e($row->phone),
                    'phone_alt' => e($row->phone_alt),
                    'notes' => e($row->notes),
                    'created_at' => optional($row->created_at)->format('Y-m-d H:i'),
                ];
            });

            return response()->json([
                'draw' => (int)$request->input('draw'),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $data,
            ]);
        }

        return view('Admin.CRUDS.land_request.index');
    }

    public function show(LandRequest $landRequest)
    {
        return view('Admin.CRUDS.land_request.show', compact('landRequest'));
    }

    public function uploadExcelView()
    {
        return view('Admin.CRUDS.land_request.uploadExcel');
    }

    public function uploadExcelStore(Request $request)
    {
        ini_set('memory_limit', '512M');
        $request->validate([
            'sheet' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $dir = 'excel/upload/';
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            $extension = $file->getClientOriginalExtension();
            $fileName = 'land-requests-' . rand(11111111, 99999999) . '.' . $extension;
            $file->move($dir, $fileName);

            $path = $dir . $fileName;
            [$ok, $message] = $this->import($path);
            if ($ok) {
                return response()->json(['code' => 200, 'message' => __('تم الاستيراد بنجاح')]);
            }
            return response()->json(['code' => 421, 'message' => $message ?? __('حدث خطأ أثناء الاستيراد')], 421);
        }

        return response()->json(['code' => 421, 'message' => __('الملف غير صالح')], 421);
    }

    private function import(string $file): array
    {
        $sheets = Excel::toArray(null, $file);
        if (!isset($sheets[0])) {
            return [false, __('لا توجد بيانات في الملف')];
        }
        $rows = $sheets[0];

        // If file has header row, attempt to detect and skip it
        $startIndex = 0;
        if (!empty($rows) && is_array($rows[0])) {
            $first = $rows[0];
            $firstConcat = mb_strtolower(implode(' ', array_map('strval', $first)));
            if (str_contains($firstConcat, 'name') || str_contains($firstConcat, 'الاسم') || str_contains($firstConcat, 'هوية')) {
                $startIndex = 1;
            }
        }

        for ($i = $startIndex; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (!is_array($row)) continue;
            // Normalize values
            $col0 = isset($row[0]) ? trim((string)$row[0]) : '';
            $col1 = isset($row[1]) ? trim((string)$row[1]) : '';
            $col2 = isset($row[2]) ? trim((string)$row[2]) : '';
            $col3 = isset($row[3]) ? trim((string)$row[3]) : '';
            $col4 = isset($row[4]) ? trim((string)$row[4]) : '';
            $col5 = isset($row[5]) ? trim((string)$row[5]) : '';

            if ($col0 === '' && $col1 === '' && $col2 === '' && $col3 === '' && $col4 === '' && $col5 === '') {
                continue; // skip empty row
            }

            // Column 0 is a sequence number to be ignored; take applicant name from column 1
            $applicantName = $this->cleanApplicantName($col1);

            // Phones: sometimes both phones are in one column separated by + or - or =
            $phonesField = $col3;
            $phone = null; $phoneAlt = null;
            if ($phonesField !== '') {
                $parts = preg_split('/[+\-=]+/u', $phonesField);
                $parts = array_values(array_filter(array_map(fn($p) => trim($p), $parts), fn($v) => $v !== ''));
                if (isset($parts[0])) $phone = $this->onlyDigits($parts[0]);
                if (isset($parts[1])) $phoneAlt = $this->onlyDigits($parts[1]);
            }

            // If third column didn't contain separator and col4 looks like a phone, use it as alt
            if ($phoneAlt === null && $col4 !== '' && $this->looksLikePhone($col4)) {
                $phoneAlt = $this->onlyDigits($col4);
            }

            // Notes: prefer col5 if exists else col4 (when not used as alt phone)
            $notes = '';
            if ($col5 !== '') {
                $notes = $col5;
            } else {
                if (!($this->looksLikePhone($col4))) {
                    $notes = $col4;
                }
            }

            // Skip if name or national id is empty
            $nationalId = $this->onlyDigits($col2);
            if ($applicantName === '' || $nationalId === null) {
                continue;
            }

            // Skip if a record with same name and national_id already exists
            $exists = LandRequest::where('applicant_name', $applicantName)
                ->where('national_id', $nationalId)
                ->exists();
            if ($exists) {
                continue; // ignore this line per requirement
            }

            // Save
            LandRequest::create([
                'applicant_name' => $applicantName,
                'national_id' => $nationalId,
                'phone' => $phone,
                'phone_alt' => $phoneAlt,
                'notes' => $notes,
            ]);
        }

        return [true, null];
    }

    private function cleanApplicantName(string $raw): string
    {
        // Remove leading numbers and separators (e.g., "1- ", "12+", "3=")
        $raw = trim($raw);
        $raw = preg_replace('/^[\d\s+\-=_.,:;]+/u', '', $raw);
        return trim($raw);
    }

    private function onlyDigits(?string $v): ?string
    {
        if ($v === null) return null;
        $digits = preg_replace('/\D+/u', '', (string)$v);
        return $digits !== '' ? $digits : null;
    }

    private function looksLikePhone(string $v): bool
    {
        $digits = preg_replace('/\D+/u', '', $v);
        return strlen($digits) >= 7; // simple heuristic
    }
}
