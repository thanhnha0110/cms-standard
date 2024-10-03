<!DOCTYPE html>

<html lang="en">

	<x-head title="Money Saved" />

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<x-header />

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<x-menu />
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<x-subheader />

					<div class="m-content">
						@yield('content')

						
					</div>

					
				</div>
			</div>
			<!-- end:: Body -->

			<x-footer />
		</div>

		<!-- end:: Page -->

		<x-sidebar />
		<x-scroll-top />
		<x-quick-nav />
		<x-scripts />
	</body>

	<!-- end::Body -->
</html>