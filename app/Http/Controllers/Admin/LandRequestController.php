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
            $columns = ['id','applicant_name','national_id','nationality','birth_date','subscriber_number','race_participation_count','camels_count','phone','phone_alt','last_participation_date','notes'];
            $orderColIndex = (int)($request->input('order.0.column', 6));
            $orderDir = $request->input('order.0.dir', 'desc');
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $query->orderBy($orderCol, $orderDir === 'asc' ? 'asc' : 'desc');

            // Pagination
            $start = (int)$request->input('start', 0);
            $length = (int)$request->input('length', 25);
            if ($length !== -1) {
                $query->skip($start)->take($length);
            }

            $data = $query->get()->map(function ($row) use ($start) {
                $statusText = null;
                // Normalize check_status to Arabic labels
                $val = trim((string)($row->check_status ?? ''));
                if ($val !== '') {
                    $lower = mb_strtolower($val);
                    if (in_array($lower, ['1','yes','true','success','passed','ناجح','اجتاز'])) {
                        $statusText = 'اجتاز';
                    } elseif (in_array($lower, ['0','no','false','failed','فاشل','لم يجتاز'])) {
                        $statusText = 'لم يجتاز';
                    } else {
                        // Any non-empty custom text from evaluation stays as-is
                        $statusText = e($row->check_status);
                    }
                }
                return [
                    'id' => $row->id,
                    'index' => null,
                    // Use actions field to carry the textual check status for the index "تحقق" column
                    'actions' => $statusText,
                    'applicant_name' => e($row->applicant_name),
                    'national_id' => e($row->national_id),
                    'nationality' => e($row->nationality),
                    'birth_date' => optional($row->birth_date)->format('Y-m-d'),
                    'subscriber_number' => e($row->subscriber_number),
                    // 'subscriber_status' removed from index view
                    'race_participation_count' => (int) $row->race_participation_count,
                    'camels_count' => (int) $row->camels_count,
                    'phone' => e($row->phone),
                    'phone_alt' => e($row->phone_alt),
                    'last_participation_date' => optional($row->last_participation_date)->format('Y-m-d'),
                    'notes' => e($row->notes),
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

    public function uploadExcelUpdateView()
    {
        return view('Admin.CRUDS.land_request.updateFromExcel');
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
                return redirect()->back()->with('success', __('تم الاستيراد بنجاح'));
            }
            return redirect()->back()->withErrors(['sheet' => $message ?? __('حدث خطأ أثناء الاستيراد')]);
        }

        return redirect()->back()->withErrors(['sheet' => __('الملف غير صالح')]);
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

    public function uploadExcelUpdateStore(Request $request)
    {
        ini_set('memory_limit', '512M');
        $request->validate([
            'sheet' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $dir = 'excel/upload/updates/';
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            $extension = $file->getClientOriginalExtension();
            $fileName = 'land-requests-update-' . rand(11111111, 99999999) . '.' . $extension;
            $file->move($dir, $fileName);

            $path = $dir . $fileName;
            [$ok, $message, $stats] = $this->importUpdate($path);
            if ($ok) {
                $msg = __('تم تحديث البيانات بنجاح') . ' - ' . sprintf(__('تم تحديث %d سجل/سجلات. تم تجاهل %d سطر بدون تطابق.'), $stats['updated'] ?? 0, $stats['ignored'] ?? 0);
                return redirect()->back()->with('success', $msg);
            }
            return redirect()->back()->withErrors(['sheet' => $message ?? __('حدث خطأ أثناء التحديث')]);
        }

        return redirect()->back()->withErrors(['sheet' => __('الملف غير صالح')]);
    }

    private function importUpdate(string $file): array
    {
        $sheets = Excel::toArray(null, $file);
        if (!isset($sheets[0])) {
            return [false, __('لا توجد بيانات في الملف'), []];
        }
        $rows = $sheets[0];
        if (empty($rows)) {
            return [true, null, ['updated' => 0, 'ignored' => 0]];
        }

        // Build header map by Arabic titles
        $header = array_map(fn($v) => trim(mb_strtolower((string)$v)), $rows[0]);
        $map = [];
        $aliases = [
            'subscriber_number' => ['رقم المشترك','subscriber number'],
            'applicant_name' => ['اسم المالك','إسم المالك','name'],
            'nationality' => ['الجنسية','nationality'],
            'birth_date' => ['تاريخ الميلاد','birthdate','date of birth'],
            'subscriber_status' => ['حالة المشترك','subscriber status'],
            'country' => ['البلد','الدولة','country'],
            'id_type' => ['نوع الاثبات الشخصي','نوع الإثبات الشخصي','id type'],
            'national_id' => ['رقم بطاقة الاثبات الشخصي','رقم بطاقة الإثبات الشخصي','national id','الهوية','رقم الهوية'],
            'camels_count' => ['عدد المطايا','عدد  المطايا','camels count'],
            'phone' => ['رقم الجوال الأساسي','الجوال الأساسي','phone','mobile'],
            'phone_alt' => ['رقم الجوال الفرعي','الجوال الفرعي','alt phone'],
            'race_participation_count' => ['عدد مرات المشاركة بالسباقات','عدد مرات المشاركه بالسباقات'],
            'last_participation_date' => ['تاريخ اخر مشاركه','تاريخ آخر مشاركة','آخر مشاركة'],
            'race_id' => ['raceid','race id']
        ];
        foreach ($aliases as $key => $names) {
            foreach ($names as $name) {
                $idx = array_search(mb_strtolower($name), $header, true);
                if ($idx !== false) { $map[$key] = $idx; break; }
            }
        }

        $updated = 0; $ignored = 0;
        $startIndex = 1; // skip header
        for ($i = $startIndex; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (!is_array($row)) { $ignored++; continue; }
            $get = function(string $k) use ($map, $row) {
                if (!isset($map[$k])) return null;
                $v = $row[$map[$k]] ?? null;
                return is_string($v) ? trim($v) : $v;
            };

            $nationalId = $this->onlyDigits((string)($get('national_id') ?? ''));
            if (!$nationalId) { $ignored++; continue; }

            $model = LandRequest::where('national_id', $nationalId)->first();
            if (!$model) { $ignored++; continue; }

            $applicantName = (string)($get('applicant_name') ?? '');
            $subscriberNumber = (string)($get('subscriber_number') ?? '');
            $nationality = (string)($get('nationality') ?? '');
            $subscriberStatus = (string)($get('subscriber_status') ?? '');
            $camelsCount = $get('camels_count');
            $raceCount = $get('race_participation_count');
            $phone = $this->onlyDigits((string)($get('phone') ?? ''));
            $phoneAlt = $this->onlyDigits((string)($get('phone_alt') ?? ''));
            $birthRaw = $get('birth_date');
            $lastPartRaw = $get('last_participation_date');

            $payload = [];
            if ($applicantName !== '') $payload['applicant_name'] = $this->cleanApplicantName($applicantName);
            if ($subscriberNumber !== '') $payload['subscriber_number'] = $subscriberNumber;
            if ($nationality !== '') $payload['nationality'] = $nationality;
            if ($subscriberStatus !== '') $payload['subscriber_status'] = $subscriberStatus;
            if ($camelsCount !== null && $camelsCount !== '') $payload['camels_count'] = (int) preg_replace('/\D+/','', (string)$camelsCount);
            if ($raceCount !== null && $raceCount !== '') $payload['race_participation_count'] = (int) preg_replace('/\D+/','', (string)$raceCount);
            if ($phone) $payload['phone'] = $phone;
            if ($phoneAlt) $payload['phone_alt'] = $phoneAlt;
            if ($birthRaw !== null && $birthRaw !== '') $payload['birth_date'] = $this->parseDate($birthRaw);
            if ($lastPartRaw !== null && $lastPartRaw !== '') $payload['last_participation_date'] = $this->parseDate($lastPartRaw);

            if (!empty($payload)) {
                $model->update($payload);
                // Re-evaluate check status after updates
                [$status] = $this->evaluateCheckStatus($model->fresh());
                $model->update(['check_status' => $status]);
                $updated++;
            } else {
                $ignored++;
            }
        }

        return [true, null, ['updated' => $updated, 'ignored' => $ignored]];
    }

    private function parseDate($v): ?string
    {
        // If numeric, treat as Excel serial date
        if (is_numeric($v)) {
            $base = \Carbon\Carbon::create(1899, 12, 30, 0, 0, 0, 'UTC');
            return $base->copy()->addDays((int)$v)->format('Y-m-d');
        }
        $s = trim((string)$v);
        if ($s === '') return null;
        try {
            return \Carbon\Carbon::parse($s)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
    public function checkStatus(LandRequest $landRequest)
    {
        [$status, $reasons] = $this->evaluateCheckStatus($landRequest);
        $payload = ['check_status' => $status];
        if ($status === 'failed') {
            $payload['notes'] = implode('، ', array_filter($reasons, fn($r) => trim((string)$r) !== ''));
        }
        $landRequest->update($payload);
        return response()->json([
            'ok' => true,
            'id' => $landRequest->id,
            'check_status' => $status,
            'reasons' => $reasons,
        ]);
    }

    public function checkStatusAll(Request $request)
    {
        $query = LandRequest::query();
        $updated = 0;
        $failed = 0;
        $query->chunkById(500, function ($chunk) use (&$updated, &$failed) {
            foreach ($chunk as $model) {
                [$status, $reasons] = $this->evaluateCheckStatus($model);
                $payload = ['check_status' => $status];
                if ($status === 'failed') {
                    // Update notes column with failure reasons (joined by comma)
                    $payload['notes'] = implode('، ', array_filter($reasons, fn($r) => trim((string)$r) !== ''));
                }
                $model->update($payload);
                $status === 'passed' ? $updated++ : $failed++;
            }
        }, 'id');

        return redirect()->back()->with('success', __('تم تحديث حالة الفحص لجميع الطلبات') . " ({$updated} ✓ / {$failed} ×)");
    }

    private function evaluateCheckStatus(LandRequest $model): array
    {
        $reasons = [];

        // Rule 1: Nationality is قطري or قطرى
        $nat = trim(mb_strtolower((string)$model->nationality));
        $natNormalized = str_replace(['ي'], ['ى'], $nat); // normalize ya to alef maksura
        $allowed = ['قطري', 'قطرى'];
        if (!in_array($nat, $allowed, true) && !in_array($natNormalized, $allowed, true)) {
            $reasons[] = 'الجنسية ليست قطري/قطرى';
        }

        // Rule 2: Age >= 25
        if (!$model->birth_date) {
            $reasons[] = 'تاريخ الميلاد غير متوفر';
        } else {
            try {
                $age = \Carbon\Carbon::parse($model->birth_date)->age;
                if ($age < 25) {
                    $reasons[] = 'العمر أقل من 25 سنة';
                }
            } catch (\Throwable $e) {
                $reasons[] = 'تاريخ الميلاد غير صالح';
            }
        }

        // Rule 3: camels_count >= 10
        if ((int)$model->camels_count < 10) {
            $reasons[] = 'عدد المطايا أقل من 10';
        }

        // Rule 4: last_participation_date is 2 years ago or earlier (i.e., <= now - 2 years)
        if (!$model->last_participation_date) {
            $reasons[] = 'تاريخ آخر مشاركة غير متوفر';
        } else {
            try {
                $limit = \Carbon\Carbon::now()->subYears(2)->startOfDay();
                $last = \Carbon\Carbon::parse($model->last_participation_date)->startOfDay();
                if ($last < $limit) {
                    $reasons[] = 'تاريخ آخر مشاركة أحدث من سنتين';
                }
            } catch (\Throwable $e) {
                $reasons[] = 'تاريخ آخر مشاركة غير صالح';
            }
        }

        $status = empty($reasons) ? 'passed' : 'failed';
        return [$status, $reasons];
    }
}
