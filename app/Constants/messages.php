<?php

namespace App\Constants;

class Messages
{
    /*  
    * Response Constant Messages is given
    */
    public const MSG_PAGE_NOT_FOUND = "not found";
    public const MSG_CREATE_SUCCESS = " has been created successfully";
    public const MSG_UPDATE_SUCCESS = " has been updated successfully";
    public const MSG_DELETE_SUCCESS  = " has been deleted successfully";
    public const MSG_LIST_SUCCESS  = " has been fetched successfully";
    public const MSG_ENABLED_SUCCESS  = "has been enabled successfully";
    public const MSG_DISABLED_SUCCESS  = "has been disabled successfully";

    /*  
    * Log Constant Messages is given
    */

    public const LOG_MSG_STORE = "@store Controller"; 
    public const LOG_MSG_INDEX = "@index Controller"; 
    public const LOG_MSG_DELETE = "@destroy Controller"; 
    public const LOG_MSG_UPDATE = "@update Controller"; 
    public const LOG_MSG_EDIT = "@show Controller"; 
    public const LOG_MSG_ALL = "@all Controller"; 
    public const LOG_MSG_IS_ACTIVE = "@toggleStatus Controller"; 
}
