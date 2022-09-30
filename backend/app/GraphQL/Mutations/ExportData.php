<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Purchase;

class ExportData
{   
    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $purchases = Purchase::where('period_id', $args['period'])->whereIn('unit_id', $args['units'])->get();

        $header = ['batchno', 'vendor', 'term', 'discamt', 'duedate', 'discdate', 'invoice', 'tot', 'voucher', 'purdate', 'dept', 'description', 'glamt', 'glacct', 'doctype', 'accttype'];

        $outdata = '';
        foreach($header as $column) {
            $outdata .= $column . "\t";
        }
        $outdata .= "\n";

        foreach ($purchases as $purchase) {
            $unit = $purchase->unit;
            $period = $purchase->period;
            $charges = $purchase->items;
            $vendor = $purchase->vendor;
            $terms = $vendor ? $vendor->terms : null;
            $glAccounts = $unit ? $unit->glAccounts : null;

            //batchno
            $outdata .= $unit && $period ? $unit->code . $period->week . $period->month : 'null';
            $outdata .= "\t";

            //vendor
            $outdata .= $vendor ? $vendor->code : 'null';
            $outdata .= "\t";

            //term
            $outdata .= $terms ? $terms[0]->id : 'null';
            $outdata .= "\t";

            //discamt
            $outdata .= $terms ? number_format((double)$terms[0]->disc_percent, 2, '.', '') : 'null';
            $outdata .= "\t";

            //duedate
            $date = date_create($purchase->date);
            $outdata .= $terms ? date_format(date_add($date, date_interval_create_from_date_string($terms[0]->due_days . " days")), "m/d/y") : 'null';
            $outdata .= "\t";

            //discdate
            $date = date_create($purchase->date);
            $outdata .= $terms ? date_format(date_add($date, date_interval_create_from_date_string($terms[0]->disc_days . " days")), "m/d/y") : 'null';
            $outdata .= "\t";

            //invoice
            $outdata .= $purchase->number;
            $outdata .= "\t";

            //tot
            $total_amount = 0;
            foreach($charges as $charge) {
                $total_amount += $charge->amount;
            }
            $outdata .= $charges ? number_format((double)$total_amount, 2, '.', '') : 'null';
            $outdata .= "\t";

            //voucher
            $outdata .= $unit ? $unit->code . $purchase->id : 'null';
            $outdata .= "\t";

            //purdate
            $outdata .= date_format(date_create($purchase->date), "m/d/y");
            $outdata .= "\t";

            //dept
            $outdata .= $unit ? $unit->code : 'null';
            $outdata .= "\t";

            //description
            $outdata .= $unit && $vendor 
                    ? $vendor->code == $unit->sysco 
                    ? $vendor->name 
                    : $unit->name
                    : 'null';
            $outdata .= "\t";

            //glamt
            $outdata .= $charges ? '$' . number_format((double)$total_amount, 2, '.', '') : 'null';
            $outdata .= "\t";

            //glacct
            $itemId = $glAccounts 
                    ? $glAccounts[0]->parent 
                    ? $glAccounts[0]->parent->item_id . '-' . $glAccounts[0]->item_id
                    : $glAccounts[0]->item_id . '-000' 
                    : 'null';
            $outdata .= $unit && $glAccounts ? $unit->code . '-'. $itemId : 'null';
            $outdata .= "\t";

            //doctype
            $outdata .= "null";
            $outdata .= "\t";

            //accttype
            $outdata .= 'PURCH';

            $outdata .= "\n";
        }

        return $outdata;
    }
}