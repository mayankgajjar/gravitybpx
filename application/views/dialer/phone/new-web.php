<div class="main-dialer">
    <div class="dialer-call-wrapper">
        <div class="dialer-dis dialer-icon">
            <a href="javascript:;" class="dialer_ic" onclick="diaplayCallDiv('zoomIn')">
                <img src="<?php echo site_url() ?>assets/images/dialer.svg" alt="dialer_icon"/>
            </a>
        </div>
        <div class="call-field" >
            <div id="call-field" class="phone-dialer dialer1">
                <div class="call-out">
                    <div class="call-out-icon">
                        <a id="callBtn" href="javascript:;" onclick="javascript:call();">
                            <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon"/>
                        </a>
                    </div>
                </div>
                <div class="dialer-input-div">
                    <input type="text" id="phone_num" name="phone_num"  class="form-control Numbers" placeholder="Phone Number..."/>
                </div>
                <div class="msg-bubbles">
                    <div class="msg-bubbles-icon">
                        <a href="javascript:;" onclick="chatwindow('zoomIn')">
                            <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .dialer-call-wrapper -->
    <div class="dialer-box-wrapper" id="dialer-box" style="display: none;">
        <div class="toggle-icon-bar">
            <a href="javascript:;" onclick="minimizeDiv('dialer_screen', 'dialer-box')">
                <img class="toggle-icon" src="<?php echo site_url() ?>assets/images/toggle-icon.png"/>
            </a>
        </div>
        <div class="dialer_screen">
            <div class="dialer_header">
                <div class="profile">
                    <div class="profile-image">
                        <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image" />
                    </div>
                </div>
                <div class="profile-content">
                    <h4 class="leadname">John Smith</h4>
                    <p class="leadtype">Client</p>
                </div>
                <div class="btn-min">
                    <a href="javascript:;" onclick="minimizeDiv('dialer_screen', this)"><img src="<?php echo site_url() ?>assets/images/min.png"/></a>
                    <a href="javascript:;" onclick="closeDialPad()"><img src="<?php echo site_url() ?>assets/images/close-icon.png"/></a>
                </div>
            </div>
            <div class="dialer_body">
                <div class="dialer_btn">
                    <div class="dialer-btn-container">
                        <div class="dialer-btnss">
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(1)">1</a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(2)">2<span>abc</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(3)">3<span>def</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(4)">4<span>ghi</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(5)">5<span>jkl</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(6)">6<span>mno</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(7)">7<span>pqrs</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(8)">8<span>tuv</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(9)">9<span>wxyz</span></a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf('*')">*</a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf(0)">0</a>
                            <a class="btn btn-info" href="javascript:;" onclick="dtmf('#')">#</a>
                        </div>
                        <div class="dialer-call-actions">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="jQuery('#transModal').modal('show');">
                                        <img src="<?php echo site_url() ?>assets/images/transfer.png" alt="transfer" />
                                        <span>Transfer</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="<?php echo site_url() ?>assets/images/hold.png" alt="hold" />
                                        <span>hold</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="mute()" id="linkmute">
                                        <img src="<?php echo site_url() ?>assets/images/mute.png" alt="mute" />
                                        <span>Mute</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="record('start');" id="recOpt">
                                        <img src="<?php echo site_url() ?>assets/images/record.png" alt="record" />
                                        <span>Record</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="inbound-action dialer-call-actions" style="display: none;">
                            <ul>
                                <li class="answer">
                                    <a href="javascript:;" onclick="answer()">
                                        <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="Answer"/>
                                    </a>
                                </li>
                                <li class="reject">
                                    <a href="javascript:;" onclick="reject()">
                                        <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="Reject" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dialer_footer">
                <div class="call-ui-wrapper">
                    <div class="call-ui-footer phone-dialer dialer2">
                        <div class="call-out">
                            <div class="call-out-icon">
                                <a href="javascript:;" title="Hangup"  onclick="hangup()">
                                    <img style="transform: rotate(190deg)" id="dpad-call-out" src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon"/>
                                </a>
                            </div>
                        </div>
                        <div class="dialer-input-div">
                            <input type="text"  class="form-control" placeholder="Phone Number..." id="dpad-phone" name="dpad-phone"/>
                        </div>
                        <div class="msg-bubbles">
                            <div class="msg-bubbles-icon">
                                <a href="javascript:;">
                                    <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- lead view -->
            <div class="profile-popup-wrapper" id="lead-view">
                <div class="toggle-icon-bar">
                    <a href="javascript:;" onclick="minimizeDiv('popup-screen', 'lead-view')">
                        <img class="toggle-icon" src="<?php echo site_url() ?>assets/images/toggle-icon.png">
                    </a>
                </div>
                <div class="popup-screen">
                    <form id="lead-pop-form" method="post" onsubmit="saveLead(event);return false;">
                        <div class="dialer_header">
                            <div class="profile">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                            <div class="profile-content">
                                <h4 class="leadname1">&nbsp;</h4>
                                <p class="leadtype">&nbsp;</p>
                            </div>
                            <div class="btn-min">
                                <a href="javascript:;"><img src="<?php echo site_url() ?>assets/images/min.png"/></a>
                                <a href="javascript:;" onclick="leadPop();"><img src="<?php echo site_url() ?>assets/images/close-icon.png"/></a>
                            </div>
                        </div>
                        <div class="dialer_body">
                            <div class="dialer-form">
                                <input type="hidden" name="called_count" id="called_count" />
                                <input type="hidden" name="CallUUID" id="CallUUID"/>
                                <input type="hidden" name="lead_id" id="lead_id"/>
                                <input type="hidden" name="dispo" />
                                <input type="hidden" name="last_local_call_time" value="" />
                                <input type="hidden" name="recordingId" value="" />
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" id="cellno" id="cellno" name="cellno"/>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email"/>
                                </div>
                                <div class="detail_address">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit,app...</label>
                                        <input type="text" class="form-control" id="app" name="app"/>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city" name="city"/>
                                    </div>
                                    <div class="form-group">
                                        <?php $states = $this->db->get('state')->result(); ?>
                                        <label>State</label>
                                        <select class="form-control" id="state" name="state" style="width: 55%;">
                                            <option value=""></option>
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>"><?php echo $state->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Zip</label>
                                    <input type="text" class="form-control" id="zip" name="zip"/>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea class="form-control" id="notes" name="notes"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn-default" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- lead view -->
        </div>
    </div>
    <div class="dialer-chatbox-wrapper" id="dialer-chatbox" style="display: none;">
        <div id="chating_view"> </div>
    </div>
</div>
<!-- Modal -->
<div id="dispModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
                <h4 class="modal-title"><?php echo 'Disposition Screen' ?></h4>
            </div>
            <div class="modal-body">
                <ul class="disp-ul">
                    <li><a href="javascript:;" onclick="changeDispo('CALLBACK', event)"><?php echo 'CALLBACK' ?></a></li>
                    <li><a href="javascript:;" onclick="changeDispo('SALE MADE', event)"><?php echo 'SALE MADE' ?></a></li>
                    <li><a href="javascript:;" onclick="changeDispo('QUOTED', event)"><?php echo 'QUOTED' ?></a></li>
                    <li><a href="javascript:;" onclick="changeDispo('NEW', event)"><?php echo 'NOT ANSWERED' ?></a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default green" onclick="updateDispo(event)"><?php echo 'Save' ?></a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="transModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
                <h4 class="modal-title"><?php echo 'Call Transfer Screen' ?></h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" onsubmit="return false;">
                    <div class="form-group">
                        <label for="transfer_num">Phone Number:</label>
                        <input type="text" class="form-control" id="transfer_num" name="transfer_num">
                    </div>
                    <button type="button" class="btn green" onclick="transfer('blind')"><?php echo 'Blind Transfer' ?></button>
                    <button type="button" class="btn green" onclick="transfer('warm')"><?php echo 'Warm Transfer' ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- For Chating Buuble -->
<div class="chat-bubble"></div>
<!-- /For Chating Buuble -->