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
        <script type='text/javascript'src="/mapv4/js/map/multiselect-dropdown.js"></script>
        <style>
            select {width: 20em;}
        </style>

    </head>
	<body>



    <div class="container">
        <div class="row">
            <div class="col">
                <hr/>
                <label>Название маршрута</label>
                <select name="nameTrack" id="nameTrack"  multiselect-search="true" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))" multiselect-hide-x="false">
                </select>
                <!--hr/>
                <label>Тип GNSS</label>
                <select name="typeGNSS" id="typeGNSS"  multiselect-search="true" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))" multiselect-hide-x="false">
                </select-->
                <!--hr/>
                <label>Время   DataTracks,hotlineLayer,mymap </label>
                <select name="times" id="times"  multiselect-search="true" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.innerHTML))" multiselect-hide-x="false">
                </select-->
                <button type="submit" class="btn btn-light" onclick="buildMap()">Построить маршруты</button>
                
            </div>
        </div>
        <!--canvas id="chartContainer" style="height: 300px; width: 80%;"   > </canvas-->
    </div>



    
    <div style='padding: 200px;'>
        <!--label id='selected_track' styles='font-size:22px;'></label-->
        <div id="mapid"></div>
        <div class="legend">
            <div class="grad">
                <span>0 м</span>
                <span>2 м</span>
                <span>4 м</span>
                <span>6 м</span>
            </div>
        </div>
    </div>
        <style>
            .legend{
                margin-top: 0px;
                margin-bottom: 10px;
                display: flex;
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
        </style>
            
            <script type='text/javascript' src="/mapv4/js/map/leaflet.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/menu.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/pdop_map.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/leaflet.hotline.js"></script>
            <script type='text/javascript' src="/mapv4/js/map/leaflet.control.select.src.js"></script>
    </body>
</html>

