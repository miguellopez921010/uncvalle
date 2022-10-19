<div class="panel panel-default">
  	<div class="panel-heading">EMAILS</div>
  	<div class="panel-body">  		
  		<div class="table-responsive" style="max-height: 250px !important; overflow-y: auto;">
			<table id="TableEmailsNotaria" name="TableEmailsNotaria" class="table table-stripped table-bordered table-condensed">
				<thead>
					<tr>
						<th class="text-center">Email</th>	
					</tr>
				</thead>
				<tbody>
					<tr style="display: none;" id="FilaEmailNotaria">
						<td>
							<input type="email" name="EmailNotaria[]" class="form-control">	
						</td>
					</tr>
					<?php 
					$EmailsEnCreacion = true;
					if(isset($EmailsNotaria)){
						if(!empty($EmailsNotaria)){
							$EmailsEnCreacion = false;

							foreach ($EmailsNotaria AS $EN) {
								?>
					<tr>
						<td>
							<input type="email" name="EmailNotaria[]" class="form-control" value="<?=$EN['Email']?>">	
						</td>
					</tr>
								<?php
							}
						}
					}

					if($EmailsEnCreacion){
						?>
					<tr>
						<td>
							<input type="email" name="EmailNotaria[]" class="form-control">	
						</td>
					</tr>
						<?php
					}
					?>
							
				</tbody>
			</table>
		</div>
		<button type="button" onclick="AgregarFilaTabla('TableEmailsNotaria', 'FilaEmailNotaria')" class="btn btn-danger">Agregar</button>
  	</div>
</div>