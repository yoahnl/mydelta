@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col s12">
            <div id="companymydelta1_hype_container" style="margin:auto;position:relative;width:450px;height:100px;overflow:hidden;" aria-live="polite">
                <script type="text/javascript" charset="utf-8" src="company_mydelta_1.hyperesources/companymydelta1_hype_generated_script.js?13543"></script>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->
            @foreach($companys as $company)
                <div class="col s10">
                    <div class="card-panel hoverable">
                        <a href="{{URL::to('company/'.$company->name)}}" class="grey_delta">
                            <img src="{{$company->image}}" alt="{{$company->name}}" width="100">
                            <h5 class="center grey-black_delta">{{$company->name}}</h5>
                            <hr>
                            <a href="" >
                                <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary">En savoir plus</button>
                            </a>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <section class="enterprise">
        <div class="row">
            <div class="col s12">
                <div class="content">
                    @foreach($companys as $company)
                    <div class="col m3">
                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="{{$company->image}}">
                            </div>
                            <div class="card-content">
                                <span class="card-title activator tilte-enterprise">{{$company->name}}</span>
                                <p>Sed fruatur sane hoc solacio atque hanc insignem ignominiam, quoniam uni praeter se inusta sit, putet esse leviorem, dum modo, cuius exemplo se consolatur, eius exitum expectet, praesertim cum in Albucio nec Pisonis libidines nec audacia Gabini fuerit ac tamen hac una plaga conciderit, ignominia senatus</p>
                                <div class="btn-info-card">
                                    <a href="{{URL::to('company/'.$company->name)}}" class="waves-effect waves-light btn btn-align-center">Découvrir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endsection