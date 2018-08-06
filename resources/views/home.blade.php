@extends('layouts.index')

@section('content')



@include('partials.nav')

 <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>

    
    <div class="container text-center">
    <h2>Chat</h2>
    <div id="chat">
        <div class="col-md-12" style="height: 500px; background-color: #fff; border: 1px solid #000">
        <ul id="messages">
            <li v-for="message in messages" :key="message.id"> @{{ message }}  </li>
        </ul>
        </div>
        <form v-on:submit="send3333">
            NAME
            <input v-model="name"> <br>
            chat
            <input v-model="message">
            <button>Send</button>

        </form>

    </div>

</div>

    <br>
    <h2>GPS</h2> 

    <div id="gps">
        
        <form v-on:submit="sendgps">
            urt
            <input v-model="urt"> <br>
            urgun
            <input v-model="urgun">
            <button>Send</button>

        </form>

    </div>


    <h3>Socket</h3>
     <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe0oBRtJMjHilHZyFzeX-Lg0VKNymeDvk&callback=initMap">
    </script>
    <script>

    var lat_gps = -25.344;
    var lng_gps = 131.036;

    function initMap(lat_gps, lng_gps) {

        console.log(lat_gps,lng_gps);

      // The location of Uluru
      if(lat_gps == undefined || lng_gps == undefined){
        var uluru = {lat: -25.344, lng: 131.036};
      }
      else{
        var uluru = {lat: parseFloat(lat_gps), lng: parseFloat(lng_gps)};
      }
     
      // The map, centered at Uluru
      // console.log(uluru);
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 4, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});
    }

        
            var socket = io.connect('http://192.168.1.115:3000');

        new Vue({

            el:'#chat',

            data : {
                messages: [],
                message:'',
                name:'{{ Auth::user()->name }}'
            },

            mounted: function() {

                socket.on('chat.message', function(name , message) {

                    this.messages.push(name + ' : ' + message);

                }.bind(this));

            },

            methods: {
                send3333: function(e) {

                    // var item = {
                    //  name ''
                    // };
                    // console.log(this.name)
                    // alert('msj');
                    socket.emit('chat.message',this.name,this.message);

                    this.message = '';

                    e.preventDefault();

                }
            }

        });

        new Vue({

            el:'#gps',

            data : {
                messages: [],
                urgun:'',
                urt:''
            },

            mounted: function() {

                socket.on('gps.message', function(urgun , urt) {

                    // this.messages.push(name + ' : ' + message);

                    initMap(urgun,urt);

                }.bind(this));

            },

            methods: {
                sendgps: function(e) {

                    // var item = {
                    //  name ''
                    // };
                    // console.log(this.name)
                    // alert('gps');
                    socket.emit('gps.message',this.urgun,this.urt);

                    this.message = '';

                    e.preventDefault();

                }
            }

        });

    </script>

@endsection
