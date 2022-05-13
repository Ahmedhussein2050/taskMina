 <div class="modal fade bd-example-modal-lg" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">{{ _i('Product Info') }}</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="products-lists">
                     <div class="content">
                         <div class="row btns-row d-flex justify-content-between">
                             <div class="col-md-12 main-btn">
                                 <a class="btn btn-tiffany btn-rounded btn-xlg" id="add-btn"
                                     onclick="addNewProduct()"><i
                                         class="fa fa-plus"></i>{{ _i('Add Info To Product') }}</a>
                             </div>

                         </div>
                         <ul class="nav nav-tabs" id="myTab" role="tablist">
                             @foreach (get_languages() as $key => $lang)
                                 <li class="nav-item">
                                     <a class="nav-link @if ($lang->id == getLang()) active @endif "
                                         id="{{ $lang->id }}" data-toggle="tab" href="#lang-{{ $lang->id }}"
                                         role="tab" aria-controls="home" aria-selected="true">{{ $lang->title }}</a>
                                 </li>
                             @endforeach
                         </ul>


                         <div class="tab-content" id="myTabContent">

                             @foreach (get_languages() as $key => $lang)
                                 <div class="tab-pane fade @if ($lang->id == getLang()) show active @endif"
                                     id="lang-{{ $lang->id }}" role="tabpanel"
                                     aria-labelledby="{{ $lang->id }}">
                                     <div class="row btns-row d-flex justify-content-between m-b-10">


                                         <div class="container text-center">
                                             <form id="add_info_form" method="post" class="j-pro"
                                                 enctype="multipart/form-data" data-parsley-validate=""
                                                 style="box-shadow:none; background: none">
                                                 <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                  {{-- <input type="hidden" name="product_id"  value="{{ $product }}"> --}}
                                                 <div class="col-md-12" id="info_boxes" style="overflow: auto;   ">
                                                     @if ($rowData != null)
                                                         @foreach ($rowData as $row)
                                                             <div class="col-md-12 row">
                                                                 <div class="col-md-10">
                                                                     <input type="text" class="form-control"
                                                                         form="add_info_form"
                                                                         value="{{ $row->title }}"
                                                                         name="info[{{ $row->id }}][{{ $lang->id }}]">
                                                                 </div>
                                                                 <div class="col-md-2"><a id="info_add"
                                                                         class=" btn color-white  waves-effect waves-light btn-primary">
                                                                         <i class="ti-plus"> </i></a></div>
                                                             </div>
                                                         @endforeach
                                                     @else
                                                         <div class="col-md-12 row">
                                                             <div class="col-md-10">
                                                                 <input type="text" class="form-control"
                                                                     form="add_info_form" value=""
                                                                     name="info[][{{ $lang->id }}]">
                                                             </div>
                                                             <div class="col-md-2"><a id="info_add"
                                                                     class=" btn color-white  waves-effect waves-light btn-primary">
                                                                     <i class="ti-plus"> </i></a></div>
                                                         </div>
                                                     @endif

                                                 </div>
                                                 <div class="col-md-12 info_adding_boxes"
                                                     id="info_adding_boxes-{{ $lang->id }}">

                                                 </div>


                                             </form>
                                         </div>
                                     </div>

                                 </div>
                             @endforeach
                         </div>
                     </div>
                 </div>


             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                 <button onclick="info()" class="btn btn-primary">{{ _i('Save') }}</button>
             </div>
         </div>
     </div>
 </div>
