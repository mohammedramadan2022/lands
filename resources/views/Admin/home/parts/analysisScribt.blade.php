<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['إجمالي المستخدمين', 'إجمالي المستخدمين (العضويات المجانية)', 'إجمالي المشتركين (العضويات المدفوعة)', 'إجمالي المنشورات', 'إجمالي الحملات التسويقية', 'إجمالي الحساب الموثقة','إجمالي طلبات التوثيق', 'إجمالي الحسابات النشطة', 'إجمالي الحسابات غير النشطة', 'إجمالي المتواجدين حاليا', 'إجمالي الرسائل', 'إجمالى المشاهدات','إجمالي الإعجابات'
            ],
            datasets: [{
                label: '# of Votes',
                data: [{{$users}}, {{$ordinary_users}}, {{$distinct_users}}, {{$portfolios}}, {{$shopping_campaign}}, {{$verified_users}},{{$verified_user_requests}}, {{$active_users}}, {{$blocked_users}}, 2, {{$contacts}}, {{$views}},{{$likes}}],
                borderWidth: 1,
                backgroundColor: [
                    '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#F4FF33', '#33FFF4',
                    '#F433FF', '#FF8333', '#33A1FF', '#FF5733', '#F4F433', '#33FF57', '#FF33A1'
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },

        }
    });


</script>
