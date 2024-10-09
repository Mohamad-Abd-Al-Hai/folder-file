<?php

namespace App\Enums;

enum Permission: string
{
    case CREATE_FOLDER = 'create-folder';
    case UPDATE_FOLDER = 'update-folder';
    case GET_FOLDER_CHILDREN = 'get-folder-children';
    case DELETE_FOLDER = 'delete-folder';

    case CREATE_FILE = 'create-file';
    case UPDATE_FILE = 'update-file';
    case DELETE_FILE = 'delete-file';

    case VIEW_ROLES = 'view-roles';
    case VIEW_PERMISSIONS = 'view-permissions';
    case ADD_ROLE = 'add-role';
    case ADD_PERMISSIONS_TO_ROLE = 'add-permissions-to-role';
    case ADD_ROLE_TO_USER = 'add-role-touser';

    case SEARCH = 'search';
}
