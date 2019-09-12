<?php

namespace Modules\Report\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
     

    public function toArray($request) {
        

        return $this->collection->transform(function($row, $key){ 
            
            $affected_document = null;
            if(in_array($row->document_type_id,['07','08']) && $row->note){

                $series = ($row->note->affected_document) ? $row->note->affected_document->series : $row->note->data_affected_document->series;
                $number =  ($row->note->affected_document) ? $row->note->affected_document->number : $row->note->data_affected_document->number;
                $affected_document = $series.' - '.$number;
            }

            $signal = $row->document_type_id;
            $state = $row->state_type_id;
            
 
               
            return [
                'id' => $row->id,
                'group_id' => $row->group_id,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => $row->soap_type->description,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'number' => $row->number_full,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => $row->total_exportation,


                'total_exonerated' =>  $row->total_exonerated,
                'total_unaffected' =>  $row->total_unaffected,
                'total_free' =>  $row->total_free,
                'total_taxed' => $row->total_taxed,
                'total_igv' =>  $row->total_igv,
                'total' =>  $row->total,
 
 

                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'document_type_description' => $row->document_type->description,
                'document_type_id' => $row->document_type->id,   
                'affected_document' => $affected_document,   
                'user_name' => ($row->user) ? $row->user->name : '',
                'user_email' => ($row->user) ? $row->user->email : '',

                'notes' => (in_array($row->document_type_id, ['01', '03'])) ? $row->affected_documents->transform(function($row) {
                    return [
                        'id' => $row->id,
                        'document_id' => $row->document_id,
                        'note_type_description' => ($row->note_type == 'credit') ? 'NC':'ND',
                        'description' => $row->document->number_full,
                    ];
                }) : null,

            ];
        });
    }
}
