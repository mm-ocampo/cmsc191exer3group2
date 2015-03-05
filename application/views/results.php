<body>
	<div class="row">
		<div class="col-md-12 topLine2"></div>
	</div>

	<div class="row rowLogo">
		<div class="col-md-4 col-md-offset-4 text-center">
			<img class="img-circle horse smallLogo" src= "<?php echo base_url(); ?>assets/img/horse.jpg" />
			<h3 class="engineName">FastEngine</h3>
		</div>
	</div>
	<div class="row searchBox">
		 <div class="col-md-6 col-md-offset-3">
		 	<form method="get" action="<?php echo base_url();?>index.php/search" id="searchForm">
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

	<!--THESE ARE THE RESULTS -->


	<div class="row result">
		<div class="col-md-6 scrollHide1">
			<h4 class="resultsHeading text-center">Results1: </h4>
			<div class="resultsPane">
				<?php
					if(empty($results1)){
						echo  '<h5>No match found T.T</h5>';
					}else{
					    foreach($results1 as $result)
					    {
					        echo  '<h5>'.$result->coursecode.'</h5>'.$result->weight;
					        if(str_word_count($result->coursedesc) <= 15){
					        	echo  '<p>'.$result->coursedesc.'</p>';
					        	echo  '<p>'.str_word_count($result->coursedesc).'</p>';
					        }else{
					        	echo  '<p>'.implode(' ', array_slice(explode(' ', $result->coursedesc), 0, 15)).'...</p>';
					        	echo  '<p>'.str_word_count($result->coursedesc).'</p>';
					        }

					    }
					}
				?>
			</div>
		</div>
		
		<div class="col-md-6 scrollHide2">
			<h4 class="resultsHeading text-center">Results2: </h4>
			<div class="resultsPane">
				<h5>CMSC124</h5>
				<p>
				    Ipsum dolor sit amet, consectetuer. adipiscing elit. Sit amet, consectetuer
				    a, venenatis vitae, justo. Imperdiet a, venenatis vitae, justo. Vitae, justo...
				</p>
				<h5>CMSC124</h5>
				<p>
				    Ipsum dolor sit amet, consectetuer. adipiscing elit. Sit amet, consectetuer
				    a, venenatis vitae, justo. Imperdiet a, venenatis vitae, justo. Vitae, justo...
				</p>
				<h5>CMSC124</h5>
				<p>
				    Ipsum dolor sit amet, consectetuer. adipiscing elit. Sit amet, consectetuer
				    a, venenatis vitae, justo. Imperdiet a, venenatis vitae, justo. Vitae, justo...
				</p>
				<h5>CMSC124</h5>
				<p>
				    Ipsum dolor sit amet, consectetuer. adipiscing elit. Sit amet, consectetuer
				    a, venenatis vitae, justo. Imperdiet a, venenatis vitae, justo. Vitae, justo...
				</p>
				<h5>CMSC124</h5>
				<p>
				    Ipsum dolor sit amet, consectetuer. adipiscing elit. Sit amet, consectetuer
				    a, venenatis vitae, justo. Imperdiet a, venenatis vitae, justo. Vitae, justo...
				</p>
			</div>
		</div>
	</div>



	<div class="row text-center backToHome">
			<a href="<?php echo base_url(); ?>">
				<span class="glyphicon glyphicon-home homeButton" aria-hidden="true"></span> <br/> Home
			</a>
	</div>

	
</body>
</html>