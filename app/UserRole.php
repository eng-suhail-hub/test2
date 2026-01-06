<?php

namespace App;

enum UserRole: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case UNIVERSITY_ADMIN = 'UNIVERSITY_ADMIN';
    case STUDENT = 'STUDENT';
}
