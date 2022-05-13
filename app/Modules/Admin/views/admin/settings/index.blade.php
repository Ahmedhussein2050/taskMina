@extends('admin.layout.index',
[
	'title' => _i('Settings'),
	'subtitle' => _i('Settings'),
	'activePageName' => _i('Settings'),
	'activePageUrl' => route('settings.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => route('settings.index') ,
])

@push('css')
    <style>
        .blog-page {
            margin: 43px;
            height: 200px;
        }

        h3 i {
            font-size: 45px !important;
        }

        .counter-card-1 [class*="card-"] div > i,
        .counter-card-2 [class*="card-"] div > i,
        .counter-card-3 [class*="card-"] div > i {
            font-size: 30px;
            color: #1abc9c !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ url('admin/settings/get') }}"
                                   class="text-primary">{{_i('Basic Settings') }}</a></h3>
                            <p>{{ _i('Link, logo, name, location') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ url('admin/shipping') }}"
                                   class="text-primary">{{_i('Shipping Settings') }}</a></h3>
                            <p>{{ _i('setting') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ url('admin/pages') }}"
                                   class="text-primary">{{_i('pages Settings') }}</a></h3>
                            <p>{{ _i('pages') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div> -->

            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ url('admin/shipping') }}"--}}
            {{--									   class="text-primary">{{_i('Shipping Settings') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('Connect with shipping companies') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--								<i class="icofont icofont-truck-loaded"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ url('admin/transferBank') }}"--}}
            {{--									   class="text-primary">{{_i('bank transfer') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('Activating bank transfers') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--								<i class="icofont icofont-money-bag"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ route('storeOptions.index') }}"--}}
            {{--									   class="text-primary">{{_i('Store Options') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('Site control options') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--									<i class="icofont icofont-circuit"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ url('admin/brands') }}"--}}
            {{--									   class="text-primary">{{  _i('Brands') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('View and control brands') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--								<i class="icofont icofont-gift-box"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ route('sms.index') }}"--}}
            {{--								   class="text-primary ">{{  _i('SMS name reservation') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('Preparing documents to reserve a store name') }}</p>--}}
            {{--							<div class="progress">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100"></div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--							   <i class="icofont icofont-ui-messaging"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ url('admin/newsletters') }}"--}}
            {{--								   class="text-primary">{{  _i('NewsLetters') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('NewsLetters Control') }}</p>--}}
            {{--							<div class="progress ">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100"></div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--							<i class="icofont icofont-envelope-open"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ url('admin/settings/products') }}"--}}
            {{--								   class="text-primary">{{  _i('Products') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('Products Control') }}</p>--}}
            {{--							<div class="progress ">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100"></div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--							<i class="icofont icofont-listing-box"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ url('admin/settings/chat') }}"--}}
            {{--								   class="text-primary">{{  _i('Chat') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('Chat Plugin Code') }}</p>--}}
            {{--							<div class="progress ">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100"></div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--							<i class="icofont icofont-ui-messaging"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

        </div>

    </div>
    {{--    Advanced settings--}}
    <div class="page-header">
        <div class="page-header-title">
            <h4>{{_i('Advanced settings')}}</h4>
        </div>
    </div>
    <div class="page-body">
        <!-- Blog-card group-widget start -->
        <div class="row">
            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ route('seo.index') }}"--}}
            {{--									   class="text-primary">{{  _i('SEO') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('SEO') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--								<i class="icofont icofont-search-alt-1"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ url('admin/currencies') }}"--}}
            {{--								   class="text-primary">{{  _i('Currencies') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('Currencies available in the store') }}</p>--}}
            {{--							<div class="progress ">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100">--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--							<i class="fa fa-usd"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            {{--			<div class="col-md-12 col-xl-4">--}}
            {{--				<div class="card counter-card-1">--}}
            {{--					<div class="card-block-big d-flex justify-content-between">--}}
            {{--						<div>--}}
            {{--							<h3>--}}
            {{--								<a href="{{ route('taxPrep') }}"--}}
            {{--								   class="text-primary">{{  _i('TAX') }}</a>--}}
            {{--							</h3>--}}
            {{--							<p>{{ _i('Tax preparation') }}</p>--}}
            {{--							<div class="progress">--}}
            {{--								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--									 aria-valuemax="100"></div>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--						<div>--}}
            {{--						   <i class="icofont icofont-law-document"></i>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}
            {{--			</div>--}}

            {{--				<div class="col-md-12 col-xl-4">--}}
            {{--					<div class="card counter-card-1">--}}
            {{--						<div class="card-block-big d-flex justify-content-between">--}}
            {{--							<div>--}}
            {{--								<h3>--}}
            {{--									<a href="{{ route('dataRecovery.index') }}"--}}
            {{--									   class="text-primary">{{  _i('Data recovery') }}</a>--}}
            {{--								</h3>--}}
            {{--								<p>{{ _i('Recover deleted orders and products') }}</p>--}}
            {{--								<div class="progress ">--}}
            {{--									<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"--}}
            {{--										 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"--}}
            {{--										 aria-valuemax="100"></div>--}}
            {{--								</div>--}}
            {{--							</div>--}}
            {{--							<div>--}}
            {{--							   <i class="icofont icofont-refresh"></i>--}}
            {{--							</div>--}}
            {{--						</div>--}}
            {{--					</div>--}}
            {{--				</div>--}}

        </div>
    </div>
    {{--    Advanced settings--}}

    <div class="page-header">
        <div class="page-header-title">
            <h4>{{_i('Media')}}</h4>
        </div>
    </div>
    <div class="page-body">
        <!-- Blog-card group-widget start -->
        <div class="row">
            @can('Sections')
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big d-flex justify-content-between">
                            <div>
                                <h3>
                                    <a href="{{ route('section.index', 'home_sections') }}"
                                       class="text-primary">{{  _i('Home Sections') }}</a>
                                </h3>
                                <p>{{ _i('Control Home Page Sections') }}</p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                         role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div>
                                <i class="icofont icofont-pencil-alt-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('admin/settings/banners') }}"
                                   class="text-primary">{{  _i('Banners') }}</a>
                            </h3>
                            <p>{{ _i('Show banners to customers in the store') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-file-image"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('admin/settings/sliders') }}"
                                   class="text-primary">{{  _i('Sliders') }}</a>
                            </h3>
                            <p>{{ _i('Show sliders to customers in the Home Page') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-files"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="{{ url('admin/pages') }}"
                                   class="text-primary">{{  _i('Pages') }}</a>
                            </h3>
                            <p>{{ _i('Control In Pages') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-files"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="page-header">
		<div class="page-header-title">
			<h4>{{_i('Cities')}}</h4>
		</div>
	</div>
	<div class="page-body">
		<!-- Blog-card group-widget start -->
		<div class="row">
			<div class="col-md-12 col-xl-4">
				<div class="card counter-card-1">
					<div class="card-block-big d-flex justify-content-between">
						<div>
							<h3>
								<a href="{{ route('cities.index') }}"
								   class="text-primary">{{  _i('Cities') }}</a>
							</h3>
							<p>{{ _i('Control All Cities') }}</p>
							<div class="progress ">
								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
									 aria-valuemax="100"></div>
							</div>
						</div>
						<div>
							<i class="icofont icofont-file-image"></i>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
@endsection
