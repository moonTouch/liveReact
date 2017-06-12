var socket = io.connect('http://192.168.1.37:8080');                    
    
// On button click, emit a socket request with datas : image, audio from data-*
$('button').click(function () {

    var image = "";
    image = $(this).data('image');

    var audio ="";
    audio = $(this).data('audio');
    
    socket.emit('image', {image: image, audio:audio}); // Transmet le message aux autres
 });

 
// What we see on server, if event
socket.on('image', function(data) {

    // Section and #image are empty, to let place to new items
    $('section').empty();
    $('#image').empty();
    
    // if an image is sent, displays <img> with timeline
    if(typeof data.image !== 'undefined'){
        $("#image").prepend('<img src="' + data.image + '" class="center-block">');

        //TIMELINE GSAP
        //
        // animation is visible during X seconds
        var visibleTime = 3;

        var tl = new TimelineLite();
        
        // get image extension
        var extension = data.image.substring(data.image.lastIndexOf("."));
        
        // if image is a gif, no animation effects
        if (extension ==='gif'){
            TweenMax.staggerFrom("img", 1, {scale:0.5, opacity:0}, 0);
            TweenMax.staggerFrom("img", 1, {autoAlpha :1, delay:visibleTime}, 0); 
        } else {
            TweenMax.staggerFrom("img", 1, {scale:0.5, opacity:0, ease:Elastic.easeOut, force3D:true}, 0);
            TweenMax.staggerFrom("img", 1, {autoAlpha :1, delay:visibleTime, ease:Power3.easeOut, force3D:true}, 0);    
        }
        
        // timeline play
        tl.play();
    };

    // if an audio file is sent, displays <audio> and play it
    if(typeof data.audio !== 'undefined'){
        $("#image").prepend('<audio preload="auto" src="' + data.audio + '" id="player_audio"></audio>');
        
        //Play audio file
        var audio = $("#player_audio")[0];
        audio.play();
    };

});