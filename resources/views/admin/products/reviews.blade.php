@extends('admin.master')

@section('title')
   Admin Dashboard | Product Reviews
@endsection

@push('css')
<style>
    .star-rating {
        color: #ffc107;
    }
</style>
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">

            {{-- Card: Header --}}
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-star text-primary"></i> Reviews for: {{ $product->name_en }}
                    </h3>
                    <div class="card-tools w3-small">
                        <a href="{{ route('admin.productsAll') }}" 
                           class="btn btn-outline-primary btn-xs pull-right mr-2 py-1">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card: Reviews Table --}}
            <div class="card w3-round shadow-lg">
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive table-responsive-sm">
                            <table class="table table-striped table-bordered table-hover table-md">
                                <thead class="w3-small text-muted thead-light">
                                    <tr>
                                        <th scope="col" width="30">SL</th>
                                        <th scope="col">User/Name</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $key => $review)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($review->user)
                                                    {{ $review->user->name }} (User)
                                                @else
                                                    {{ $review->name }} (Guest: {{ $review->email }})
                                                @endif
                                            </td>
                                            <td class="star-rating">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </td>
                                            <td>{{ $review->comment }}</td>
                                            <td>{{ $review->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <form action="{{ route('admin.review.delete', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-danger">No reviews found for this product.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
