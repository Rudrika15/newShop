@extends('layouts.app2')

@section('content')
    <section class="section">
        @if (session()->has('success'))
            <script>
                Swal.fire(
                    'Success!',
                    '{{ session('success') }}',
                    'success'
                );
            </script>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-lg-6">
                                <h3 id="pincode-heading">
                                    Pincode List
                                </h3>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end align-items-center">
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger"><strong>* You can update the Deliverable status and Delivery
                                            Charges by clicking on the respective fields.</strong></span>
                                </div>
                            </div>
                        </div>
                        <!-- Pincode List Table -->
                        <div id="pincode-table-container">
                            <!-- Data will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination Links -->
        <div id="pagination-links">
            <!-- Pagination will be loaded here via AJAX -->
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchPincodes();

            function fetchPincodes(page = 1) {
                $.ajax({
                    url: '{{ route('pincodes.fetch') }}?page=' + page,
                    success: function(data) {
                        $('#pincode-table-container').html(generateTable(data.pincodes));
                        $('#pagination-links').html(data.pagination);
                    }
                });
            }

            function generateTable(pincodes) {
                let tableHtml = '<table id="pincode-table" class="table table-bordered text-center">';
                tableHtml += '<thead class="table-secondary">';
                tableHtml +=
                    '<tr><th>No</th><th>State</th><th>District</th><th>City</th><th>Pincode</th><th>Is Deliverable</th><th>Delivery Charges</th></tr>';
                tableHtml += '</thead><tbody>';
                pincodes.data.forEach((pincode, index) => {
                    tableHtml += `<tr>
                    <td>${(pincodes.current_page - 1) * pincodes.per_page + (index + 1)}</td>
                    <td>${pincode.state}</td>
                    <td>${pincode.district ?? '-'}</td>
                    <td>${pincode.city ?? '-'}</td>
                    <td>${pincode.pincode ?? '-'}</td>
                    <td>
                        <select class="editable-select" data-id="${pincode.id}" data-field="isDeliverable">
                            <option value="YES" ${pincode.isDeliverable === 'YES' ? 'selected' : ''}>YES</option>
                            <option value="NO" ${pincode.isDeliverable === 'NO' ? 'selected' : ''}>NO</option>
                        </select>
                    </td>
                    <td contenteditable="true" class="editable" data-id="${pincode.id}" data-field="deliveryCharges">${pincode.deliveryCharges ?? '-'}</td>
                </tr>`;
                });
                tableHtml += '</tbody></table>';
                return tableHtml;
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchPincodes(page);
            });

            $(document).on('input', '.editable', function() {
                // Only allow numeric input
                this.innerText = this.innerText.replace(/[^0-9]/g, '');
            });

            $(document).on('blur', '.editable', function() {
                let id = $(this).data('id');
                let field = $(this).data('field');
                let value = $(this).text();

                // Validate if the value is a number
                if (isNaN(value) || value.trim() === '') {
                    Swal.fire('Error!', 'Please enter a valid number.', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route('pincodes.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        field: field,
                        value: value
                    },
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error!', 'There was an error updating the data.', 'error');
                    }
                });
            });

            $(document).on('change', '.editable-select', function() {
                let id = $(this).data('id');
                let field = $(this).data('field');
                let value = $(this).val();

                $.ajax({
                    url: '{{ route('pincodes.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        field: field,
                        value: value
                    },
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error!', 'There was an error updating the data.', 'error');
                    }
                });
            });
        });
    </script>
@endsection
