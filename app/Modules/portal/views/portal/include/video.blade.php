@if ($product->video != null)
    <div class="row">
        <div class="col-md-4">
            <div class="promotion-video">
                <a data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img src="images/video-section-img.png" alt="" class="img-fluid">
                    <i class="far fa-play-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  p-0">
                    <iframe src="{{ $product->video }}" frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
@endif
