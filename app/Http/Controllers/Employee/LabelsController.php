<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;

use App\Helpers\Employee\EmployeeSessionHelper as EmployeeSessionHelper;

class LabelsController extends Controller {
    
    public function __construct() {
        $this->middleware('EmployeeRequiresLogin')->only([
            'all',
        ]);
    }
    
    public function all(Request $request) {
        $employeeObject = Employee::where([
                                        'id' => EmployeeSessionHelper::id()
                                    ])
                                    ->first();
        $labels_connected_employee = $employeeObject->labels;
        return view('employee.labels.all', 
            [
                'labels' => $labels_connected_employee
            ]
        );
    }

}
