<?php
include('session.php');
echo "\nhola search_profile.php";
echo "\nsession user=". $_SESSION['login_user'];
?>


<html ng-app="fetch">
<!--<head> -->

	
	<title>Perfiles</title> 
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FIXME: delete these unrequired lines -->	
	<!--	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="profiles_app.js"></script>
	<script type="text/javascript" src="app13.js"></script>
	
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
	-->
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
	<script type="text/javascript" src="profiles_app.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			
<!-- </head> -->
  
  
<style>
div.container {
    width: 100%;
    border: 1px solid gray;
}

<!--
footer {
    padding: 1em;
    color: white;
    background-color:  #1e8449  ;
    clear: left;
    text-align: center;
}
-->

<!--
header {

    padding: 1em;
    color: white;
    background-color:   #2e86c1 ;
    clear: left;
    text-align: center;

}
-->

nav {
    float: left;
    max-width: 160px;
    margin: 0;
    padding: 1em;
}

nav ul {
    list-style-type: none;
    padding: 0;
}
			
nav ul a {
    text-decoration: none;
}

article {
    margin-left: 170px;
    border-left: 1px solid gray;
    padding: 1em;
    overflow: hidden;
}

#menu_bar{

    #padding: 1em;
    color: white;
    background-color:   #707b7c  ;
    clear: left;
    text-align: right;
	
}

#top_bar{

    /*#padding: 1em;*/
    color: white;
    background-color:   #707b7c  ;
    clear: left;
    text-align: right;
	
}

#header_area{

    padding: 1em;
    color: white;
    background-color:   #2e86c1 ;
    clear: left;
    text-align: center;
	
}


#footer_bar {

    padding: 1em;
    color: white;
    background-color:  #1e8449  ;
    clear: left;
    text-align: center;
}

#form_div{
  
    width: 200px;
    align: center;
    margin: 0 auto;
}


</style>





<!-- <body ng-controller="dbCtrl"> -->
<body >


<!-- TOP BAR --------------------->
<div id="top_bar" class="container">

	<ul>
		<a href="#">BICOYED Costa Rica</a>
		<a href="#">Contacto +506 2253 5555, agomez@bicoyed.com</a>
	</ul>
</div>
<!-- END OF TOP BAR--------------->

<!-- HEADER AREA --------------------->
<div id="header_area" class="container">	
	<header>
	   <h1>Sistema de Gestion</h1>
	</header>
</div>
<!-- END OF HEADER AREA  -------------->

<!-- MENU BAR  --------------------->
<div id="menu_bar" class="container">
	
	<ul >
		<a href="#">Bienvenido, admin</a>
	</ul>

</div>
<!-- END OF MENU BAR  ------------- -->

<!-- MAIN AREA ------------------- -->
<div class="container">

	
	<!-- SIDENAV MENU ------ -->
	<nav id="sidenav">
	
		<ul>
			<li><a href="#">Ayuda</a></li>
			<li><a href="#">Acerca de</a></li>
		</ul>
	</nav>
	<!-- END OF SIDENAV MENU -->

	<!-- -------------1. CONTENT SECTION -->
	<article>
		
		<!-- <div class="container"> -->

		<div class="panel panel-default">
			<div class="panel-body" id="content_panel">
		  <ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#home">Pacientes</a></li>
			<li><a data-toggle="tab" href="#menu1">Empresas</a></li>
			<li><a data-toggle="tab" href="#menu2">Ayuda</a></li>
		  </ul>



		  <div class="tab-content">
			<div id="home" class="tab-pane fade in active">
			  <h3>Busqueda por paciente</h3>
		  
				<!-- controller for patient search -->
				<div ng-controller="dbCtrl">
		  
					<form>
					
						<table>
						
							<tr>
								<td>Cedula</td><td><input id="Patient_Field" type="number"  runat="server" ng-init="inputVal=''" ng-model="PatientID_Input_Model"></td>
							</tr>
							<tr>
								<td>Nombre</td><td><input id="Forename_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="Forename_Input_Model"></td>														
							</tr>
							<tr>
								<td>Primer Apellido</td><td><input id="FirstSurname_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="FirstSurname_Input_Model"></td>														
							</tr>						
						
							<tr>
								<td>Segundo Apellido</td><td><input id="SecondSurname_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="SecondSurname_Input_Model"></td>														
							</tr>	
							
							<tr>
								<td>Telefono</td><td><input id="PatientPhone_Field" type="number"  runat="server" ng-init="inputVal=''" ng-model="PatientPhone_Input_Model"></td>														
							</tr>	

							<tr>
								<td>Email</td><td><input id="PatientEmail_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="PatientEmail_Input_Model"></td>														
							</tr>	

							<tr>
								<td>Empresa</td><td><input id="CompanyID_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="CompanyID_Input_Model"></td>														
							</tr>
							
							<tr>
								<td></td>
								<td>
									<button ng-click="SearchPatient()">Buscar</button>
								</td>
							</tr>
							
						</table>
						
						
					</form> 

					<!--------- Search results ------->
					<div>
						<input type="text" ng-model="searchFilter" class="form-control">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Cedula</th>
									<th>Nombre</th>
									<th>Primer Apellido</th>
									<th>Segundo Apellido</th>
									<th>Email</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="patients in data | filter:searchFilter">
									<td>{{patients.PatientID}}</td>
									<td>{{patients.Forename}}</td>
									<td>{{patients.FirstSurname}}</td>
									<td>{{patients.SecondSurname}}</td>
									<td>{{patients.Email}}</td>
									<td>
										<a href="edit_profiles.html?Action=EditPatient&ID={{patients.PatientID}}">Editar</a>
										<a href="report.html">Reporte</a>
									</td>		

								</tr>
							</tbody>
						</table>
					</div><!--------- End of Search results ------->				
					
				</div><!-- ------- End of Search patient controller -->
					
				</div>			
			
			<div id="menu1" class="tab-pane fade">
			  <h3>Busqueda por empresa</h3>
			  
					<div ng-controller="dbCtrl"> 
					
						<form>
						
							<table>
							
								<tr>
									<td>Nombre</td>
									<td><input id="CompanyID_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="CompanyID2_Input_Model"></td>
								</tr>
								<tr>
									<td>Telefono</td>
									<td><input id="CompanyPhone_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="CompanyPhone_Input_Model"></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><input id="CompanyEmail_Field" type="text"  runat="server" ng-init="inputVal=''" ng-model="CompanyEmail_Input_Model"></td>
								</tr>
								<tr>
									<td></td>
									<td><button ng-click="SearchCompany()">Buscar</button></td>
								</tr>
								
							</table>

							<br>
							
							<!--------- Search results ------->
							<div>
								<input type="text" ng-model="searchFilter" class="form-control">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Email</th>
											<th>Telefono</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="companies in data | filter:searchFilter">
											<td>{{companies.CompanyID}}</td>
											<td>{{companies.Email}}</td>
											<td>{{companies.Phone}}</td>
											<td>
												<a href="edit_profiles.html?Action=EditCompany&ID={{companies.CompanyID}}">Editar</a>
												<a href="report.html">Reporte</a>
											</td>		

										</tr>
									</tbody>
								</table>
							</div>
							<!-- ------- End of Search results -->					
							
						</form>

					</div><!-- End of Company search Controller -->			
				
			</div> <!--End of Company Search tab-->
			
			
			<div id="menu2" class="tab-pane fade">
			  <h3>Tips generales</h3>
			  <p>Introduzca cualquier criterio de busqueda en los campos y luego haga click sobre el boton de Busqueda </p>
			</div>

		  </div> <!-- end of tab content -->
		  
		  
		  
		  
		</div>

		</div>
		<!-- </div> -->
		
	</article>
	<!-- -------------END OF CONTENT SECTION -->


	
	
	
</div>
<!-- END OF MAIN AREA --------------------->

	<div id="footer_bar" class="container">	
		<footer>2016 - Athelog Data Services</footer>
	</div>

</body>

</html>

