<body>
	<div class="row">
		<div class="col-md-12 topLine"></div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-5 text-center">
			<img class="img-circle horse" src= "<?php echo base_url(); ?>assets/img/horse.jpg" />
			<h1 class="engineName">FastEngine</h1>
		</div>
	</div>
	<div class="row searchBox">
		 <div class="col-md-6 col-md-offset-3">
		 	<form method="get" onsubmit="return validateForm()" action="<?php echo base_url();?>index.php/search" name="searchForm" id="searchForm">
			    <div class="input-group">
			      <input type="text" class="form-control" placeholder="Search for..." name="searchBox" required>
			      <span class="input-group-btn">
                      <!--input type="submit" class="btn btn-success" name="searchButton" value="Search"/-->
			        <button class="btn btn-success" type="submit" form="searchForm">
			        	<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			        </button>
			      </span>
			    </div>
			</form>
		  </div>
	</div>



	<div class="row text-center carousel">

		<div class="col-md-6 col-md-offset-3">

			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					    <div class="item active">
					       Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
					    </div>
					    <div class="item">
					        imperdiet a, venenatis vitae, justo.
					    </div>
					    <div class="item">
					        Duis leo. Sed fringilla mauris sit amet nibh.
					    </div>
				  </div>
			</div>

		</div>

	</div>
</body>
</html>