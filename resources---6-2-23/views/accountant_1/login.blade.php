@extends('layouts.master4')
@section('css')
@endsection
@section('content')
<div class="page">
	<div class="page-single">
		<div class="container">
			<div class="row">
				<div class="col mx-auto">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<div class="card">
								<div class="card-body">
									<div class="text-center title-style mb-6">
										<h1 class="mb-2">Sign in to account</h1>
										<p class="text-muted text-left">Enter your email and OTP to login</p>
									</div>
									<div class="input-group mb-4">
										<input type="text" class="form-control" placeholder="Email ID">
									</div>
									<div class="row justify-content-end mb-4">
										<div class="col-4">
											<button type="button" class="btn  btn-primary btn-block px-4">Send OTP</button>
										</div>
									</div>
									<div class="input-group mb-4">
										<input type="text" class="form-control" placeholder="OTP">
									</div>
									<div class="row justify-content-end">
										<div class="col-4">
											<button type="button" onclick="location.href = '/accountant/services&requests';" class="btn  btn-primary btn-block px-4">Verify</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
@endsection