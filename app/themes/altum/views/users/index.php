<?php defined('ALTUMCODE') || die() ?>


<div class="custom-container">
    <div class="userPage pb-4">
        <div class="headingName">
            <h1 class="headTitle"><?= l('users.header') ?></h1>
            <!-- <button class="primaryBigButton" data-toggle="modal" data-target="#addUserModal">Add user</button> -->
        </div>
        <div class="card">
            <h1>Comming Soon!</h1>
        </div>

        <!-- <div class="userListLabel">
            <label class="commonLabel usercol">Users</label>
            <label class="commonLabel rolecol">Role</label>
            <label class="commonLabel foldercol">Folders</label>
            <label class="commonLabel statecol">State</label>
            <label class="commonLabel buttoncol buttoncol1"></label>
        </div>
        <div>
            <div class="userRow">
                <div class="usercol">
                    <label>somil+test@3waytech.co</label>
                    <span>Creation date: November 17, 2022</span>
                </div>
                <div class="rolecol">
                    <label class="userLabel">Admin</label>
                </div>
                <div class="foldercol">-</div>
                <div class="statecol">
                    <button  type="button" class="active">Active</button>
                </div>
                <div class="buttoncol" style="border: none;"></div>
            </div>
            <div class="userRow">
                <div class="usercol">
                    <label>niraj.3waysource+test1@gmail.com</label>
                    <span>Creation date: November 19, 2022</span>
                </div>
                <div class="rolecol">
                <label class="userLabel">Admin</label>
                </div>
                <div class="foldercol">-</div>
                <div class="statecol">
                    <button  type="button">Pending</button>
                </div>
                <div class="buttoncol">
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path></svg>
                    </button>
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm0,2h0l-5.84,5a1.89,1.89,0,0,1-2.34,0L5,6H19Zm0,12H5a1,1,0,0,1-1-1V7.79L9.53,12.5a3.91,3.91,0,0,0,4.94,0L20,7.79V17A1,1,0,0,1,19,18Z"></path><path d="M7.29,13.29l-2,2a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l2-2a1,1,0,0,0-1.42-1.42Z"></path><path d="M16.71,13.29a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>
                    </button>
                    <button class="userBtn" data-toggle="modal" data-target="#addDeleteModal">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>
                    </button>
                </div>
            </div>
            <div class="userRow">
                <div class="usercol">
                    <label>somil+test@3waytech.co</label>
                    <span>Creation date: November 17, 2022</span>
                </div>
                <div class="rolecol">
                <label class="userLabel">Limited</label>
                </div>
                <div class="foldercol">
                    <div>
                        <select name="search_by" id="filters_limited_by" class="form-control">
                        <option value="New folder">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 10px; font-size: 22px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path></svg>
                            New folder</option>
                        <option value="newF">newF</option>
                        </select>
                    </div>
                </div>
                <div class="statecol">
                    <button  type="button">Pending</button>
                </div>
                <div class="buttoncol">
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path></svg>
                    </button>
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm0,2h0l-5.84,5a1.89,1.89,0,0,1-2.34,0L5,6H19Zm0,12H5a1,1,0,0,1-1-1V7.79L9.53,12.5a3.91,3.91,0,0,0,4.94,0L20,7.79V17A1,1,0,0,1,19,18Z"></path><path d="M7.29,13.29l-2,2a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l2-2a1,1,0,0,0-1.42-1.42Z"></path><path d="M16.71,13.29a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>
                    </button>
                    <button class="userBtn" data-toggle="modal" data-target="#addDeleteModal">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>
                    </button>
                </div>
            </div>
            <div class="userRow m-0">
                <div class="usercol">
                    <label>somil+test@3waytech.co</label>
                    <span>Creation date: November 17, 2022</span>
                </div>
                <div class="rolecol">
                    <label class="userLabel">Collaborator</label>
                </div>
                <div class="foldercol">
                    <div>
                        <select name="search_by" id="filters_detail_by" class="form-control">
                        <option value="New folder">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 10px; font-size: 22px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path></svg>
                            New folder</option>
                            <option value="newF">newF</option>
                        </select>
                    </div>
                </div>
                <div class="statecol">
                    <button  type="button">Pending</button>
                </div>
                <div class="buttoncol">
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path></svg>
                    </button>
                    <button class="userBtn mr-3">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4Zm0,2h0l-5.84,5a1.89,1.89,0,0,1-2.34,0L5,6H19Zm0,12H5a1,1,0,0,1-1-1V7.79L9.53,12.5a3.91,3.91,0,0,0,4.94,0L20,7.79V17A1,1,0,0,1,19,18Z"></path><path d="M7.29,13.29l-2,2a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l2-2a1,1,0,0,0-1.42-1.42Z"></path><path d="M16.71,13.29a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>
                    </button>
                    <button class="userBtn" data-toggle="modal" data-target="#addDeleteModal">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>
                    </button>
                </div>            
            </div>
        </div> -->

        <!-- Add/Edit User modal -->
        <div class="modal smallmodal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <h1>User registration</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                            <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                        </svg>
                    </button>
                    <div class="modal-body p-0">
                        <div class="form-group">
                            <label for="email_title" class="commonLabel d-block">Email</label>
                            <input id="email_title" onchange="LoadPreview()" name="email_title" class="form-control" value="" data-reload-qr-code="">
                        </div>

                        <div class="form-group">
                            <label for="filters_role_by" class="commonLabel fieldLabel d-block">Role</label>
                            <select name="search_by" id="filters_role_by" class="form-control">
                                <option value="select">select</option>
                                <option value="Admin">Admin</option>
                                <option value="Collaborator">Collaborator
                                    <svg class="MuiSvgIcon-root ml-8" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                                        <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                                        <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                                    </svg>
                                </option>
                                <option value="Collaborator">Limited
                                    <svg class="MuiSvgIcon-root ml-8" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                                        <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                                        <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                                    </svg>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filters_folder_by" class="commonLabel fieldLabel d-block">Folders</label>
                            <select name="search_by" id="filters_folder_by" class="form-control">
                                <option value="New folder">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 10px; font-size: 22px;">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path>
                                    </svg>
                                    New folder
                                </option>
                                <option value="newF">newF</option>
                            </select>
                        </div>
                        <div class="modalButton d-flex">
                            <button class="primaryBigButton outline" data-dismiss="modal" aria-label="Close">Cancel</button>
                            <button class="primaryBigButton">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete User modal -->
        <div class="modal smallmodal fade" id="addDeleteModal" tabindex="-1" aria-labelledby="addDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content modal-content1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                            <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                        </svg>
                    </button>
                    <div class="modal-body p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 140 140">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #e5e7ef;
                                    }

                                    .cls-2 {
                                        fill: #fff;
                                    }
                                </style>
                            </defs>
                            <circle class="cls-1" cx="70" cy="70" r="70" />
                            <path class="cls-2" d="M81.84,98H56.58a8,8,0,0,1-8-7.33L45.22,50h48L89.81,90.63A8,8,0,0,1,81.84,98Z" />
                            <path d="M101.19,49h-64a1,1,0,0,0,0,2H44.3l3.32,39.72a9,9,0,0,0,9,8.25H81.84a9.06,9.06,0,0,0,9-8.25L94.12,51h7.07a1,1,0,0,0,0-2ZM88.81,90.55a7,7,0,0,1-7,6.41H56.58a7,7,0,0,1-7-6.41L46.31,51h45.8Z" />
                            <path d="M57.22,45h24a2,2,0,0,0,0-4h-24a2,2,0,0,0,0,4Z" />
                            <path d="M58,88h.07A1,1,0,0,0,59,86.93l-2-27a1,1,0,1,0-2,.14l2,27A1,1,0,0,0,58,88Z" />
                            <path d="M79.93,88H80a1,1,0,0,0,1-.93l2-27a1,1,0,1,0-2-.14l-2,27A1,1,0,0,0,79.93,88Z" />
                            <path d="M69,88a1,1,0,0,0,1-1V60a1,1,0,0,0-2,0V87A1,1,0,0,0,69,88Z" />
                        </svg>
                        <p class="">The user "niraj.3waysource+test1@gmail.com" will be eliminated. <br>Are you sure?</p>
                    </div>
                    <div class="modalButton d-flex">
                        <button class="primaryBigButton outline" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="primaryBigButton">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>