<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\CopyAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class changeController extends Controller
{
    public function changePass(Request $request)
    {
        ini_set('max_execution_time', 36000);
    
        // Determine the page number
        $page = $request->input('page', 1);
    
        // Define the number of items per page
        $perPage = 100;
        $totalAccounts = CopyAccount::where('intUserLevel', '!=', 4)->count();
        return $totalAccounts;

        // Determine the total number of pages
        $totalPages = ceil($totalAccounts / $perPage);
    
    
        // Calculate the offset based on the page number and items per page
        $offset = ($page - 1) * $perPage;
    
        // Fetch accounts with pagination
        $accounts = CopyAccount::select('intID', 'varPassword')
            ->where('intUserLevel', '!=', 4)
            ->offset($offset)
            ->limit($perPage)
            ->get();
    
        foreach ($accounts as $account) {
            if (strpos($account->varPassword, '$2y$') === 0) {
                continue;
            }
    
            DB::table('tbl_account')
                ->where('intID', '=', $account->intID)
                ->update([
                    'varPassword' => Hash::make($account->varPassword)
                ]);
        }
    
        return response()->json([
            'status' => 'updated',
            'total_pages' => $totalPages
        ]);
    }
}
