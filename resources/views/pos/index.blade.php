@extends('layout/App')

@section('title', 'POS')

@section('additional-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .select2-container {
            display: block
        }

        .select2-container .select2-selection--single {
            height: 36px;
        }
        .center{
            width: 150px;
            margin: 40px auto;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Point of sales</h1>
        <ul>
            <li><a href="#"></a>Version 1</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">Product</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="input-right-icon">
                                <input class="form-control" id="searchCustomer" class="search-input" type="text" placeholder="Search Customer by Code or Name" />
                                <span class="span-right-input-icon"><i class="search-icon text-muted i-Magnifi-Glass1"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <select name="warehouse" id="find-item" class="form-control"></select>
                        </div>
                        <div class="col-lg-12">
                            <table class="table table-sm">
                                <thead>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th style="width: 180px; text-align:center; ">Qty</th>
                                    <th style="width: 30px;"></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <a class="badge badge-success xl" href="#">Lampu Jalan LED 50 WATT</a>
                                            <p>Rp. 500.000</p>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-btn mr-1">
                                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        -
                                                    </button>
                                                </span>
                                                <input type="text" name="quant[1]" style="text-align: right;" class="form-control form-sm input-sm input-number mr-1" value="1" min="1" max="9999999999999">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                        +
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                        <td style="text-align: right;">
                                            <button type="button" class="btn btn-danger">
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-primary m-1 footer-delete-right" type="button">
                                    <i class="fa fa-cart-shopping"></i> Pay Now
                                </button>
                                <button class="btn btn-danger m-1 footer-delete-right" type="button">
                                    <i class="fa fa-power-off"></i> Cancel Transaction
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title">Select Product</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="input-right-icon">
                                <input class="form-control" id="searchProduct" class="search-input" type="text" placeholder="Scan/Search Product by Code or Name" />
                                <span class="span-right-input-icon"><i class="search-icon text-muted i-Magnifi-Glass1"></i></span>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <table id="tbl-material-list" class="table table-sm">
                                <thead>
                                    <th>#</th>
                                    <th>Product ID</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Product Image</th>
                                    <th></th>
                                </thead>
                                <tbody>
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>    
@endsection

@section('additional-js')
<script src="{{ asset('/assets/js/select2.min.js') }}"></script>
<script>
    // alert(base_url)
    $(function(){
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $('.btn-number').click(function(e){
            e.preventDefault();
            
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    } 
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
        
                } else if(type == 'plus') {
        
                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
        
                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function(){
           $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            
            minValue =  parseInt($(this).attr('min'));
            maxValue =  parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            
            name = $(this).attr('name');
            if(valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if(valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) || 
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
        });
        
        $(document).on('select2:open', (event) => {
            const searchField = document.querySelector(
                `.select2-search__field`,
            );
            if (searchField) {
                searchField.focus();
            }
        });

        $('#find-item').select2({
            placeholder: 'Type Item Code or Description',
            width: '100%',
            minimumInputLength: 0,
            ajax: {
                url: base_url + '/finditemmaster',
                dataType: 'json',
                delay: 250,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: function (params) {
                    var query = {
                        search: params.term,
                        // custname: $('#find-customer').val()
                    }
                    return query;
                },
                processResults: function (data) {
                    // return {
                    //     results: response
                    // };
                    console.log(data)
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.description,
                                slug: item.description,
                                id: item.item_code,
                                ...item
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#find-item').on('change', function(){
            // alert(this.value)
            
            var data = $('#find-item').select2('data')
            console.log(data);

            // alert(data[0].material);
            // $('#partdesc'+fCount).val(data[0].partname);
            // $('#partunit'+fCount).val(data[0].matunit);
        });

        loadItemMaster();
        function loadItemMaster(){
            $("#tbl-material-list").DataTable({
                serverSide: true,
                ajax: {
                    url: base_url+'/itemmaster',
                    data: function (data) {
                        data.params = {
                            sac: "sac"
                        }
                    }
                },
                buttons: false,
                columns: [
                    { "data": null,"sortable": false, "searchable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },
                    {data: "item_code", className: 'uid'},
                    {data: "description", className: 'fname'},
                    {data: "description", className: 'fname'},
                    {data: "quantity", className: 'fname'},
                    {"defaultContent": 
                        "<button type='button' class='btn btn-primary btn-sm button-add-material'> <i class='fa fa-plus'></i> Add</button>"
                    }
                ],
                "bDestroy": true,
            });
        }
    })
</script>
@endsection