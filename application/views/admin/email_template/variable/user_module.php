<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Field to be added :</h4>
            </div>
            <div class="modal-body">     
             <div class="row">       	
                <div class="col-md-12">
                    <label class="contrl-label col-md-3">Select Field : </label>
                    <select class="form-control col-md-9" id="sel_field">
                        <option value="subject" selected>Subject</option>
                        <option value="body">Message</option>
                    </select>
                </div>
                <div class="col-md-12">
	                <div class="radio-list modal_msg_field">
	                    <label><input type="radio" name="optradio" value="{first_name}">First Name</label>
	                </div>
	            </div>
	        	<div class="col-md-12">
            	    <div class="radio-list modal_msg_field">
            	        <label><input type="radio" name="optradio" value="{last_name}">Last Name</label>
            	    </div>
            	</div>
        	    <div class="col-md-12">
        	        <div class="radio-list modal_msg_field">
        	            <label><input type="radio" name="optradio" value="{name}">Full Name</label>
        	        </div>
        	    </div>    
	            <div class="col-md-12">    
	                <div class="radio-list modal_msg_field">
	                    <label><input type="radio" name="optradio" value="{email}">Email</label>
	                </div>
				</div>
				<div class="col-md-12">                
	                <div class="radio-list modal_msg_field">
	                    <label><input type="radio" name="optradio" value="{password}">Password</label>
	                </div>
	            </div>
 	            <div class="col-md-12">    
	                <div class="radio-list modal_msg_field">
	                    <label><input type="radio" name="optradio" value="{loginlink}">Login-Link</label>
	                </div>
	            </div>
	          </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add_var">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>