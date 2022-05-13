@push('css')
    <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
@endpush

    @extends('admin.layout.index',[
        'title' => _i('Flyer'),
        'subtitle' => _i('Flyer').':'.App\Modules\Admin\Models\Products\FlyerData::where('flyer_id',$flyer->id)->where('lang_id',getLang())->first()->title,
        'activePageName' => _i('Flyer'),
        'activePageUrl' => '',
        'additionalPageUrl' => '' ,
        'additionalPageName' => '',
    ] )

    @section('content')

        @push('css')
            <style>
                .star-ratings-css {
                    unicode-bidi: bidi-override;
                    color: #c5c5c5;
                    font-size: 25px;
                    height: 25px;
                    width: 100px;
                    margin: 0 auto;
                    position: relative;
                    padding: 0;
                    text-shadow: 0px 1px 0 #a2a2a2;
                }
                .star-ratings-css-top {
                    color: #e7711b;
                    padding: 0;
                    position: absolute;
                    z-index: 1;
                    display: block;
                    top: 0;
                    right: 0;
                    overflow: hidden;
                }
                .star-ratings-css-bottom {
                    padding: 0;
                    display: block;
                    z-index: 0;
                }
                .star-ratings-sprite {
                    background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                    font-size: 0;
                    height: 21px;
                    line-height: 0;
                    overflow: hidden;
                    text-indent: -999em;
                    width: 110px;
                    margin: 0 auto;
                }
                .star-ratings-sprite-rating {
                    background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                    background-position: 0 100%;
                    float: left;
                    height: 21px;
                    display: block;
                }
            </style>
        @endpush
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
                @endif
            @endforeach
        </div>
        <div class="page-body">

            <div class="products-lists">
                <div class="content">
                    <div class="row btns-row d-flex justify-content-between">
                        <div class="col-md-12 main-btn">
                            <a class="btn btn-tiffany btn-rounded btn-xlg" id="add-btn" onclick="addNewProduct()"><i
                                    class="fa fa-plus"></i>{{_i("Add Images")}}</a>
            {!! Form::open([ 'route' => [ 'flyers.dropzone.store',$flyer->id ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
            <div>
                <h6>Upload Multiple Image By Click On Box</h6>
            </div>
            {!! Form::close() !!}
                        </div>

                    </div>


                    <hr>
                    <div class="row btns-row d-flex justify-content-between m-b-10">


                        <div class="container" >
                            <div class="row"  style="overflow: auto;  height: 500px ">

                                @foreach($flyer->Images as $image)
                                <div class="col-md-4 text-center" id="image_container_{{$image->id}}">
                                    <img class="img-thumbnail" src="{{url($image->image)}}" alt="a picture of a cat">
                                    <button onclick=" delete_image('{{route('flyers.images.destroy',$image->id)}}') "  type="button" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i>{{_i('Delete')}}</button>
                                </div>



                                @endforeach

                            </div>
                        </div>


                    </div>


                    </div>
            </div>
@push('js')
<script type="text/javascript">
    Dropzone.options.imageUpload = {
        maxFilesize         :       100,
        acceptedFiles: ".jpeg,.jpg,.png,.zip",

        init: function () {
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    location.reload();
                }
            });
        }
    };



     function delete_image(url) {
        $.ajax({
            url: url,
            method: "get",
            "_token": "{{csrf_token()}}",
            data: {
            },
            success: function (response) {
                console.log(response)
                if (response.data == 'false'){

                    alert(0);

                } else{

                  // alert('#image_container_'+response.id);
                    $('#image_container_'+response.id).remove();


                }
            }
        });
    }

</script>
        @endpush


    @endsection
