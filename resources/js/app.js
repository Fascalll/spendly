import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

import Chart from 'chart.js/auto';

import DataTable from 'datatables.net-bs5';

window.Chart = Chart;

document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('#transactions-table');

    if (!table) {
        return;
    }

    new DataTable(table, {
        responsive: false,
        scrollX: true,
        pageLength: 10,
        lengthMenu: [10, 15, 25, 50, 100],
        ordering: true,
        searching: true,
        language: {
            search: 'Cari:',
            searchPlaceholder: 'Cari transaksi...',
            lengthMenu: 'Tampilkan _MENU_ transaksi',
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ transaksi',
            infoEmpty: 'Tidak ada transaksi',
            infoFiltered: '(disaring dari _MAX_ transaksi)',
            zeroRecords: 'Transaksi tidak ditemukan',
            emptyTable: 'Belum ada transaksi',
            paginate: {
                first: 'Pertama',
                last: 'Terakhir',
                next: 'Selanjutnya',
                previous: 'Sebelumnya',
            },
            aria: {
                sortAscending: ': aktifkan untuk mengurutkan ascending',
                sortDescending: ': aktifkan untuk mengurutkan descending',
            },
        },
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                searchable: false,
            },
        ],
    });
});
