//---------------------------------------------------------------------------

var DataTracks;
var hotlineLayer = [];
var mymap;
var controller;
var baseMaps;
var selectedTracks = [];
let acControl;
function buildSelects(select, trackData) {
    try {
        var Selects = document.getElementById(select);
        for (let item in trackData) 
        {
            Selects.innerHTML += `<option>${trackData[item]}</option>`;
            Selects.loadOptions();
        }
    } catch(e) 
    {
        console.log(`Ошибка '${e.name}': ${e.message}`);
        console.log(`${e.stack}`);
    }
  }

document.addEventListener("DOMContentLoaded",async () => {
  
    if (document.getElementById('mapid')) {
        try {
            mymap = L.map('mapid', {preferCanvas: true}).setView([15, 55], 2);
        
            mymap.setMinZoom(2);
            
            let osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mymap);

            let googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                subdomains:['mt0','mt1','mt2','mt3']
            });

            let OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'Map dat: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
            });
            
            baseMaps = {
                ToolMap: OpenTopoMap,
                OSM: osmLayer,
                Sat: googleSat,
            };

            let move = false;
            let southWest = L.latLng(-300, -300),
                northEast = L.latLng(300, 300);
            let bounds = L.latLngBounds(southWest, northEast);
            new L.LatLng(60, 210, true);

            mymap.setMaxBounds(bounds);
            mymap.on('drag', function () {
                mymap.panInsideBounds(bounds, {animate: false});
            });
        }

        catch(e) 
        {
            console.log(`Ошибка '${e.name}': ${e.message}`);
            console.log(`${e.stack}`);
        }
        mymap.on('overlayadd',  function (e) {
            try {
            mymap.fitBounds(e.layer.getBounds());
            
                /*selectedTracks.push(e.name)
                console.log('selectedTracks');
                let selected_track = document.getElementById('selected_track');
              
              
                 var idx = selectedTracks.indexOf(e.name);
                    if (idx !== -1) {
                        selected_track.innerHTML=`Текущий маршрут: " ${selectedTracks[idx]} "`;
                    } 
                    */
            }
            catch(e) 
            {
                console.log(`Ошибка '${e.name}': ${e.message}`);
                console.log(`${e.stack}`);
            }
                   
        })

       
        $('#but').on('click',function () {
            if (!$('#mapid').hasClass('on')) {

                $('#mapid').toggleClass('full')
                $('.midi').toggleClass('op')
                mymap.invalidateSize();
            }

            if ($('#mapid').hasClass('on')){

            }
        })

       /* mymap.on('overlayremove', function (e) {
            console.log(e);
            //mymap.fitBounds(e.layer.getBounds());
            console.log(selectedTracks);
            let idx = selectedTracks.indexOf(e.name);
            let selected_track = document.getElementById('selected_track');
            if (idx !== -1) {
                selectedTracks.splice(idx, 1);
                //selected_track.innerHTML=`Текущий маршрут: " ${selectedTracks[idx]} "`;
            }      
    })*/
    
  
        controller = L.control.layers()//.addTo(mymap);
        acControl =  new L.Control.AccordionLegend({
                    title: 'Маршруты',
                    position: 'topright',
                    content: [],
        })//.addTo(mymap);
        await $.ajax({
            method: "GET",
            url: "/mapv4/getGPX.php",
            dataType: "json",
            success: async function(data){
                try {
                let LAYERS = [];   
                DataTracks =  data;
                console.log(data);
                buildSelects('nameTrack',  Object.keys(data));
                
               
                
                }
                catch(e) 
                {
                    console.log(`Ошибка '${e.name}': ${e.message}`);
                    console.log(`${e.stack}`);
                }
            }

        });
     
    }
})

function buildMap()   {
    try {
        for(let hotline in  hotlineLayer)
        {
            //mymap.removeLayer(hotlineLayer[hotline])
            hotlineLayer[hotline].remove(mymap);
        }
        hotlineLayer = [];
        let LAYERS = []
        if (document.getElementById('mapid')) {
                let i=0;
                var selectedTracksTmp = Array.from(document.getElementById('nameTrack').selectedOptions).map(x=>x.innerHTML);

                for(let track in selectedTracksTmp)
                {
                    console.log(selectedTracksTmp[track])
                }
            
                var resultDataTracks = {}

                for(let track in  selectedTracksTmp)
                {
                    resultDataTracks[selectedTracksTmp[track]]=DataTracks[selectedTracksTmp[track]]
                }
            
                //console.log(resultDataTracks);
                
                for(let track in  resultDataTracks)
                {
                    for(let gnss in   resultDataTracks[track])
                    {
                    hotlineLayer['<b>' + track + '</b> ' + gnss]= L.hotline(resultDataTracks[track][gnss]['points'], {
                        min: 0.0000000,
                        max: 6.0000000,
                        weight: 12,
                        smoothFactor:0,
                        palette:{ 0: 'green', 0.500000: 'yellow', 0.9000: '#d70000', 1.00000: '#626566' },
                    })
                        .bindTooltip('', {sticky: true, opacity: 0.8})
                        .on('mousemove', function (e) {
                            let latlonPDOP = resultDataTracks[track][gnss]['points']

                            let cur_r = Math.sqrt(Math.pow(latlonPDOP[0][0] - e.latlng.lat, 2) + Math.pow(latlonPDOP[0][1] - e.latlng.lng, 2));
                            let point_r = [];
                            for (let track_point in latlonPDOP) {
                                let r = Math.sqrt(Math.pow(latlonPDOP[track_point][0] - e.latlng.lat, 2) + Math.pow(latlonPDOP[track_point][1] - e.latlng.lng, 2))
                                if (r <= cur_r) {
                                    point_r = latlonPDOP[track_point];
                                    cur_r = r;
                                }
                            }
                            
                            hotlineLayer['<b>' + track + '</b> ' + gnss].bindTooltip(`
                                        <span><b>Название маршрута:</b> ${track}</span><br>
                                        <span><b>Тип GNSS:</b> ${gnss}</span><br>
                                        <span><b>Широта:</b> ${point_r[0]}</span><br>
                                        <span><b>Долгота:</b> ${point_r[1]}</span><br>
                                        <span><b>PDOP:</b> ${point_r[2]} </span>`);


                        })
                        .on('mouseout', function () {})
                        if (!LAYERS[track]) {LAYERS[track] = []}

                            LAYERS[track].push({'title': '<b>' + track + '</b> ' + gnss,
                            'layer': hotlineLayer['<b>' + track + '</b> ' + gnss],
                            'legend': [],
                            'opacityslider': false})

                    }

                }
                var LAYERS_AND_LEGENDS = [];

                for(let track_name in LAYERS){
                    LAYERS_AND_LEGENDS.push({
                        'title': track_name,
                        layers : LAYERS[track_name]
                    })
                }
                acControl.remove();
                acControl = new L.Control.AccordionLegend({
                    title: 'Маршруты',
                    position: 'topright',
                    content: LAYERS_AND_LEGENDS,
                    //content: hotlineLayer
                }).addTo(mymap);
                acControl.toggleLayer("<b>Петрозаводск, 2022 г.</b> GLN", 'on')
               
                controller.remove(mymap);
                //controller = L.control.layers(baseMaps, hotlineLayer, { collapsed:true }).addTo(mymap).expand()
                controller = L.control.layers(baseMaps, null,{ collapsed:true }).addTo(mymap).expand()
            }
            }
       
        catch(e) 
        {
            console.log(`Ошибка '${e.name}': ${e.message}`);
            console.log(`${e.stack}`);
        }
}
