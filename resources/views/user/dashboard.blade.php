@extends('website.layouts.master')

@section('title', 'Member Dashboard - '. env('APP_NAME') )

@section('meta')
<meta name="description"
    content="Contact North Bengal for inquiries, product details, or business queries. Get in touch via phone, email, or visit our office.">
<meta name="keywords" content="contact north bengal, contact us, north bengal inquiries, phone, email, office location">
<meta property="og:title" content="Contact Us - North Bengal">
<meta property="og:description" content="Reach North Bengal for product inquiries or business partnerships.">
<meta property="og:image" content="{{ asset('frontend/assets/img/northbengal/contact_banner.png') }}">
<meta property="og:type" content="website">
@endsection
@section('content')
<!-- BREADCRUMB AREA START -->
<x-breadcrumb title="Dashboard" pageName="Dashboard" bgImage="frontend/img/bg/9.jpg" />
<!-- BREADCRUMB AREA END -->

    <!-- WISHLIST AREA START -->
    <div class="liton__wishlist-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- PRODUCT TAB AREA START -->
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav">
                                            <a class="{{ $activeTab == 'dashboard' ? 'active show' : '' }}" data-bs-toggle="tab" href="#liton_tab_1_1">Dashboard <i class="fas fa-home"></i></a>
                                            <a class="{{ $activeTab == 'order' ? 'active show' : '' }}" href="{{ route('user.orders', ['type' => 'all']) }}">Orders <i class="fas fa-file-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_3">Downloads <i class="fas fa-arrow-down"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_4">address <i class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_5">Account Details <i class="fas fa-user"></i></a>
                                            <a href="{{ route('logout') }}">Logout <i class="fas fa-sign-out-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade {{ $activeTab == 'dashboard' ? 'active show' : '' }}" id="liton_tab_1_1">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Hello   <strong>{{auth()->user()->name ?? 'User'}}</strong></p>
                                                <p>From your account dashboard you can view your <span>recent orders</span>, manage your <span>shipping and billing addresses</span>, and <span>edit your password and account details</span>.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade {{ $activeTab == 'order' ? 'active show' : '' }}" id="liton_tab_1_2">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="card">
                                                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #699403;">
                                                      <h5 class="mb-0 text-white">My Orders</h5>
                                                      @if(isset($type))
                                                        <div class="btn-group btn-group-sm">
                                                          <a href="{{ route('user.orders', ['type' => 'all']) }}" 
                                                             class="btn {{ $type=='all'?'btn-light border':'btn-outline-light' }}">All</a>
                                                          <a href="{{ route('user.orders', ['type' => 'today']) }}" 
                                                             class="btn {{ $type=='today'?'btn-light border':'btn-outline-light' }}">Today</a>
                                                          <a href="{{ route('user.orders', ['type' => 'cancelled']) }}" 
                                                             class="btn {{ $type=='cancelled'?'btn-light border':'btn-outline-light' }}">Cancelled</a>
                                                        </div>
                                                      @endif
                                                    </div>
                                                    <div class="card-body p-3">
                                                      @if($orders->count())
                                                        <div class="table-responsive">
                                                          <table class="table table-bordered table-hover mb-0">
                                                            <thead class="table-light">
                                                              <tr>
                                                                <th>ORDER</th>
                                                                <th>DATE</th>
                                                                <th>STATUS</th>
                                                                <th>TOTAL</th>
                                                                <th>ACTION</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                              @foreach ($orders as $order)
                                                                <tr>
                                                                  <td>{{ $order->id }}</td>
                                                                  <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                                  <td class="text-capitalize">{{ $order->order_status }}</td>
                                                                  <td>{{ number_format($order->grand_total, 2) }} tk</td>
                                                                  <td>
                                                                     <a class="btn btn-sm me-2" target="_blank" href="{{ route('user.orderPrint', $order->id) }}" title="Invoice"><i class="fas fa-file-invoice"></i></a>
                                                                      <a class="btn btn-sm" target="_blank" href="{{ route('user.orderChalan', $order->id) }}" title="Chalan"><i class="fas fa-receipt"></i></a>
                                                                        
                                                                  </td>
                                                                </tr>
                                                              @endforeach
                                                            </tbody>
                                                          </table>
                                                        </div>
                                                        <div class="mt-3">
                                                          {{ $orders->links() }}
                                                        </div>
                                                      @else
                                                        <p class="text-center text-muted">No orders found.</p>
                                                      @endif
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_3">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Date</th>
                                                                <th>Expire</th>
                                                                <th>Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Carsafe - Car Service PSD Template</td>
                                                                <td>Nov 22, 2020</td>
                                                                <td>Yes</td>
                                                                <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Carsafe - Car Service HTML Template</td>
                                                                <td>Nov 10, 2020</td>
                                                                <td>Yes</td>
                                                                <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Carsafe - Car Service WordPress Theme</td>
                                                                <td>Nov 12, 2020</td>
                                                                <td>Yes</td>
                                                                <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_4">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>The following addresses will be used on the checkout page by default.</p>
                                                <div class="row">
                                                    <div class="col-md-6 col-12 learts-mb-30">
                                                        <h4>Billing Address <small><a href="#">edit</a></small></h4>
                                                        <address>
                                                            <p><strong>Alex Tuntuni</strong></p>
                                                            <p>1355 Market St, Suite 900 <br>
                                                                San Francisco, CA 94103</p>
                                                            <p>Mobile: (123) 456-7890</p>
                                                        </address>
                                                    </div>
                                                    <div class="col-md-6 col-12 learts-mb-30">
                                                        <h4>Shipping Address <small><a href="#">edit</a></small></h4>
                                                        <address>
                                                            <p><strong>Alex Tuntuni</strong></p>
                                                            <p>1355 Market St, Suite 900 <br>
                                                                San Francisco, CA 94103</p>
                                                            <p>Mobile: (123) 456-7890</p>
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_5">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>The following addresses will be used on the checkout page by default.</p>
                                                <div class="ltn__form-box">
                                                    <form action="#">
                                                        <div class="row mb-50">
                                                            <div class="col-md-6">
                                                                <label>First name:</label>
                                                                <input type="text" name="ltn__name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Last name:</label>
                                                                <input type="text" name="ltn__lastname">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Display Name:</label>
                                                                <input type="text" name="ltn__lastname" placeholder="Ethan">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Display Email:</label>
                                                                <input type="email" name="ltn__lastname" placeholder="example@example.com">
                                                            </div>
                                                        </div>
                                                        <fieldset>
                                                            <legend>Password change</legend>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Current password (leave blank to leave unchanged):</label>
                                                                    <input type="password" name="ltn__name">
                                                                    <label>New password (leave blank to leave unchanged):</label>
                                                                    <input type="password" name="ltn__lastname">
                                                                    <label>Confirm new password:</label>
                                                                    <input type="password" name="ltn__lastname">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit" class="btn theme-btn-1 btn-effect-1 text-uppercase">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PRODUCT TAB AREA END -->
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->
@endsection
@push('js')
<script>
  // Profile Image Upload
  document.getElementById('profilePreview').addEventListener('click',()=>document.getElementById('profileImageInput').click());
  document.getElementById('profileImageInput').addEventListener('change', function(){
    const file = this.files[0];
    if(!file) return;
    const formData = new FormData();
    formData.append('image',file);
    formData.append('_token','{{ csrf_token() }}');
    const reader = new FileReader();
    reader.onload = e=>document.getElementById('profilePreview').src=e.target.result;
    reader.readAsDataURL(file);
    fetch("{{ route('user.uploadProfileImage') }}",{method:'POST',body:formData})
      .then(res=>res.json()).then(data=>{if(!data.success) alert('Upload failed')}).catch(()=>alert('Upload failed'));
  });
</script>
@endpush