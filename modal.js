					$(document).ready(function(){
						$('.launch-modal').click(function(){
							$('#myModal').modal({
								backdrop: 'static'
							});
							
							$('#save-event').on('click',function(evt){
								//put here code to execute when SAVE button is pressed
								
								//alert("(DEBUG)Damn it!")
								angular.element(document.getElementById('PatientController')).scope().UpdatePatient();								
								}	
							);
							
						}); 
					});