<?php

namespace App\Http\Controllers;

use App\Association;
use App\Code;
use \App\Company;
use App\Mail\ThanksForSubribe;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function GetAssociation()
    {
        $associations = Association::all();
        $cates = Association::all();
        $typeAssociations = array();

        foreach ($cates as $cate)
        {
            if (!in_array($cate->type, $typeAssociations))
            {
                array_push($typeAssociations, $cate->type);
            }
        }
        return view('association.association', compact('associations', 'cates', 'typeAssociations'));
    }

    public function GiveToAssociation($id)
    {
        $associations = Association::all();
        foreach ($associations as $association)
        {
            if ($association->name == $id) {
                return view('association.givetoassociation', compact('association', 'flashmessage'));
            }
        }
        return view('errors.notfound');
    }

    public function VerifAndAcceptDonation($id)
    {
        $code = request('code');
        $verifs = Code::all();
        $companys = Company::all();
        foreach ($verifs as $verif)
        {
            if (($verif->code == $code))
            {
                foreach ($companys as $company)
                {
                    if ($company->name == $verif->linkedto)
                    {
                        $association_names = json_decode($company->association);
                    }
                }
                    if (!in_array($id, $association_names))
                    {
                        \Session::flash('flash_message', "Oups ! On dirait que l'association n'est pas selectionné par votre entreprise");
                        \Session::put('type', 'warning');
                        return $this->GiveToAssociation($id);
                    }
                if ($verif->used == true)
                {
                    \Session::flash('flash_message', "Oups ! On dirait que ce code est déjà utilisé !");
                    \Session::put('type', 'warning');
                    return $this->GiveToAssociation($id);
                }
                $verif->used = true;
                $verif->save();
                \Session::flash('flash_message',"Grâce à vous, Entreprise ".$verif->linkedto." soutient désormais l’association ".$id." à hauteur de ".$verif->donation ."€.    
                ");
                \Session::put('type', 'sucess');
                $code_id = $verif->id;
                $associations = Association::all();
                foreach ($associations as $association)
                {
                    if ($association->name == $id)
                    {
                        return view('association.givetoassociation', compact('association', 'flashmessage', 'code_id'));
                    }
                };
            }
        }
        \Session::flash('flash_message', "Ce code n'existe pas...");
        \Session::put('type', 'danger');
        return $this->GiveToAssociation($id);
    }

    public function PutEmail($id)
    {
        $email = request('email');
        $code_id = \Session::get('code');
        $verifs = Code::all();
        foreach ($verifs as $verif)
        {
            if ($verif->id == $code_id)
            {
                $verif->email = $email;
                $verif->duto = $id;
                $verif->save();
            }
        }
        $associations = Association::all();
        foreach ($associations as $association)
        {
            if ($association->name == $id)
            {
                \Session::flash('flash_message',"L'adresse mail ".$email." a bien été enregistré.");
                \Session::put('type', 'email_done');
                \Mail::to($email)->send(new ThanksForSubribe);
                return view('association.givetoassociation', compact('association', 'flashmessage', 'code_id'));
            }
        }
    }

    public function SortAssociation($id)
    {
        $associations = Association::where('type', $id)->get();
        $cates = Association::all();
        $typeAssociations = array();

        foreach ($cates as $cate)
        {
            if (!in_array($cate->type, $typeAssociations))
            {
                array_push($typeAssociations, $cate->type);
            }
        }
        return view('association.association', compact('associations', 'cates', 'typeAssociations'));

    }
}
