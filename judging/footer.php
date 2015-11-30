<footer>
	<div class="container">
	<div class="row clearfix">

		<div class="col-xs-4">
			<address>

					<strong>Department of <?php echo $deptLngName;?></strong>
					<br><?php echo $addressBldg;?>, <?php echo $address2;?>
					<br><?php echo $addressStreet;?>
					<br>Ann Arbor, MI
					<br><?php echo $addressZip;?>
					<br>P: <?php echo $addressPhone;?>
					<br>F: <?php echo $addressFax;?>

			</address>
			<a href="https://www.lsa.umich.edu"><img class="img" src="img/lsa.png" alt="LSA at the University of Michigan"></a>

		</div>

		<div class="col-xs-4 hidden-xs">
			<a href="mailto:<?php echo strtolower($addressEmail);?>"><?php echo strtolower($addressEmail);?></a><br />
		    <a href="http://www.facebook.com/<?php echo $addressFacebook;?>"><img class="logo" width="29px" height="29px" src="img/fB29.png" alt="Visit us on Facebook" /></a><br />
		</div>
		<div class="col-xs-4 visible-xs-block">
			<a href="mailto:<?php echo strtolower($addressEmail);?>">eMail</a><br />
		    <a href="http://www.facebook.com/<?php echo $addressFacebook;?>"><img class="logo" width="29px" height="29px" src="img/fB29.png" alt="Visit us on Facebook" /></a>
		</div>
		<div class="col-xs-1"></div>
		<div class="col-xs-1 hidden-xs"></div>
		<div class="col-xs-2">
			<a href="http://www.umich.edu"><img class="mlogo img img-rounded" src="img/michigan.png" alt="University of Michigan" /></a>
		</div>

<!-- 		<div class="col-xs-1 column"></div> -->
	</div>

	<div class="row clearfix">
		<div class="col-xs-12">
		<a href="http://www.regents.umich.edu" class="btn btn-block btn-link btn-xs" type="button">© 2014 Regents of the University of Michigan</a>
		</div>
	</div>
</div>
</footer> <!-- #footer -->

  <script type="text/javascript" src="js/modernizr-latest.js"></script>
  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-formhelpers.min.js"></script>

