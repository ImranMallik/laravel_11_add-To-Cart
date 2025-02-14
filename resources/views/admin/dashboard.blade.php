<x-app-layout>
    <section class="wsus__product mt_145 pb_100">
        <div class="container">
            <h4 class="text-primary pt-3 pb-3">Dashboard</h4>
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Products</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Create New</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search products...">
                    </div>
                    <table id="productTable" class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Images</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Short Desc</th>
                                <th>Qty</th>
                                <th>SKU</th>
                                <th>Long Desc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let table = $('#productTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('products.get') }}",
                    dom: "<'row'<'col-md-6'l><'col-md-6 text-end'B>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy',
                            className: 'btn btn-outline-secondary'
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            className: 'btn btn-outline-success'
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-outline-primary'
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            className: 'btn btn-outline-danger'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'btn btn-outline-info'
                        }
                    ],
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'short_description',
                            name: 'short_description'
                        },
                        {
                            data: 'qty',
                            name: 'qty'
                        },
                        {
                            data: 'sku',
                            name: 'sku'
                        },
                        {
                            data: 'long_description',
                            name: 'long_description'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Custom Search Input
                $('#searchBox').keyup(function() {
                    table.search($(this).val()).draw();
                });
            });
        </script>
        <style>
            /* Ensure Buttons Are Properly Aligned & Spaced */
            .dt-buttons {
                display: flex;
                justify-content: end;
                /* Align to the right */
                align-items: center;
                /* Vertically center */
                gap: 8px;
                /* Space between buttons */
            }

            /* Style Buttons for Better Appearance */
            .dt-buttons .btn {
                padding: 8px 14px;
                /* Adjust padding for better clickability */
                font-size: 14px;
                /* Adjust font size */
                font-weight: 600;
                /* Make text bold */
                transition: all 0.3s ease-in-out;
                /* Smooth hover effect */
                border-radius: 5px;
                /* Rounded corners */
            }

            /* Hover Effect for Buttons */
            .dt-buttons .btn:hover {
                transform: scale(1.05);
                /* Slight zoom on hover */
            }

            /* Fix Button Wrapping Issue */
            .dt-buttons {
                flex-wrap: wrap;
                /* Prevent overflow issues */
            }

            /* Improve Table Header & Cell Alignment */
            .table th,
            .table td {
                text-align: center;
                vertical-align: middle;
            }

            /* Improve Pagination Button Styling */
            .dataTables_paginate {
                display: flex;
                justify-content: end;
            }

            .dataTables_paginate .pagination {
                margin: 0;
            }

            /* Improve Search Input Box Styling */
            .dataTables_filter {
                display: flex;
                align-items: center;
                justify-content: end;
            }

            .dataTables_filter input {
                margin-left: 10px;
                border-radius: 5px;
                padding: 6px 10px;
                border: 1px solid #ccc;
                outline: none;
                transition: all 0.3s ease-in-out;
            }

            /* Add Focus Effect to Search Box */
            .dataTables_filter input:focus {
                border-color: #007bff;
                box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            }

            /* Adjust "Show Entries" Dropdown */
            .dataTables_length {
                display: flex;
                align-items: center;
            }
        </style>
    @endpush
</x-app-layout>
