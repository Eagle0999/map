<html>
	<head>
		<title>Карта</title>   
		<meta charset="utf-8">
	    <meta name="viewport" content="/width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/mapv4/css/map/leaflet.css">
        <link rel="stylesheet" href="/mapv4/css/map/style-map.css">
        <link rel="stylesheet" href="/mapv4/css/map/leaflet.control.select.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="/mapv4/css/map/L.Control.AccordionLegend.css">
        <script type='text/javascript'src="/mapv4/js/map/multiselect-dropdown.js"></script>
        <style>
            select {width: 20em;}
        </style>

    </head>
	<body>

    

    <div class="main" >
        <!--div class="row">
            <div class="col"-->
                <div class='element1'>
                    <label  >Название маршрута</label>
                    <select  name="nameTrack" id="nameTrack"  multiple multiselect-search="true" multiselect-select-all="true"  onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))">
                    </select>
                    <!--hr/>
                    <label>Тип GNSS</label>
                    <select name="typeGNSS" id="typeGNSS"  multiselect-search="true" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))" multiselect-hide-x="false">
                    </select-->
                    <!--hr/>
                    <label>Время   DataTracks,hotlineLayer,mymap </label>
                    <select name="times" id="times"  multiselect-search="true" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))" multiselect-hide-x="false">
                    </select-->
                    <button   type="submit" class="btn btn-light" onclick="buildMap()">Построить маршруты</button>
                </div>

                <div  class='element2'>
                    <!--label id='selected_track' styles='font-size:22px;'></label-->
                    <div id="mapid">
                        <button class="btn" id="but">
                            <span class="midi"></span>
                        </button>
                    </div>
                </div>
            <!--/div>
        </div-->
        <!--canvas id="chartContainer" style="height: 300px; width: 80%;"   > </canvas-->
    </div>



    
    
    <style>
    .main {
        display: flex;
        flex-direction: column;
        /*width: 100%;*/
        flex-basis: 100%;
        padding:100px;
    }


    


    .multiselect-dropdown-search.form-control::placeholder{
        
    }
    .element1 {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-grow: 1;
        /*align-items:center;*/
        /*width: 100%;*/
        flex-basis: 50%;
        margin-bottom: 50px;
    }
    
    .element2 {
        display: flex;
        flex-direction: row;
        /*width: 100%;*/
        flex-basis: 100%;
    }
    .legend {
        margin-top: 0px;
        margin-bottom: 10px;
        display: flex;
        width: 20%;
    }

    .legend h3{
        margin: 0;
    }

    .grad{
        display: flex;
        justify-content: space-between;
        padding: 0px 5px;
        align-items: center;
        font-weight: 700;
        border-radius: 0px 0px 4px 4px;
        box-shadow: 0 5px 15px 0 rgb(0 0 0 / 10%);
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, rgb(0 171 0) 0%, rgba(255,255,0,1) 50%, rgba(255,0,0,1) 100%);
    }

    .grad span{
        text-shadow: 1px 1px 10px white;
        color: black;
        margin-top: 30px;
        font-weight: 500;
    }

    .leaflet-control-layers{
        transition: 0.2s;
        background-color: #ffffffcc;
        border-radius: 4px;
    }

    .leaflet-control-layers-expanded{
        border-top: solid 4px #157fc4;
    }

    .leaflet-tooltip-right{
        padding-left: 20px;
    }
    .leaflet-tooltip-left{
        padding-right: 20px;
    }

    .leaflet-tooltip-left, .leaflet-tooltip-right{
        border-top: solid 4px #157fc4;
        border-radius: 4px;
        border-left: none;
        border-right: none;
        font-size: 12px;
    }

    .midi{
        background-image: url('/mapv4/images/icons/increase-size-option.svg');
        padding-right: 16px;
        /*background-color: #00f6ff;*/
        background-repeat: no-repeat;
        background-size: 16px;
        background-position-x: center;
        background-position-y: center;
        height: 16px;
        display: inline;
    }

    .midi.op{
        background-image: url('/mapv4/images/icons/resize-option.svg');
    }

    #but{
        padding: 0;
        z-index: 1000;
        margin: 10px;
        margin-top: 73px;
        box-shadow: 0 1px 5px rgb(0 0 0 / 65%);
        background: #fff;
        border-radius: 5px;
        height: 26px;
        width: 26px;
        justify-content: center;
        align-items: center;
        display: flex;
    }
    #but:hover{
        background-color: #f4f4f4
    }

    #mapid{
        height:700px;
        width:100%;
        position: relative;
        display: flex;
        z-index: 1;
    }

    #mapid.full{
        position: fixed;
        z-index: 100;
        top: 0;
        left: 0;
        height: 100%;
    }

    .over{
        display: none;
    }



    .accordionlegend-section{
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin: 5px;

        margin-left: 1em !important;
    }

    .leaflet-control-accordionlegend-panel div.accordionlegend-section div.accordionlegend-layer label{
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .leaflet-control-accordionlegend-panel{
        max-height: 500px !important;
    }

    .leaflet-control-accordionlegend.leaflet-control{
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .leaflet-control-accordionlegend-panel, .leaflet-control-accordionlegend-button{
        border-radius: 5px;
        background-color: #ffffffcc;
        box-shadow: 0 1px 5px rgb(0 0 0 / 40%);
        transition: 0.2s;
    }

    .leaflet-control-accordionlegend-button{
        text-transform: uppercase;
        color: #626566 !important;
    }

    .leaflet-control-accordionlegend-button:hover{
        color: #095bc4 !important;
    }

    .leaflet-control-accordionlegend-panel{
        border-top: solid 4px #157fc4;
    }

    .leaflet-bar a{
        background-color: #ffffffcc;
        transition: 0.2s;
    }

    .accordionlegend-section-title{

    }

    .leaflet-control-accordionlegend-panel h2 {
        font-weight: 600;
        font-size: 14px;
        line-height: 26px;
        transition: 0.2s;
    }

    .leaflet-control-accordionlegend-panel h2:hover {
        color: #095bc4;
    }

    .active_sec{
        color: #095bc4 !important;
    }
 
   
   
</style>
            
            <script type='text/javascript' src="/mapv4/js/map/leaflet.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/menu.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/pdop_map.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/leaflet.hotline.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/L.Control.AccordionLegend.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/leaflet.control.select.src.js"></script>
    </body>
</html>

