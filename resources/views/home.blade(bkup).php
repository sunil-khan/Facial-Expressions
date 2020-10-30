@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}

          </div>
          @endif
          <div class="camera">
            <video id="video">Video stream not available.</video>

          </div>
          <canvas id="canvas">
          </canvas>
          <div class="output">
            <img id="photo" alt="The screen capture will appear in this box.">
          </div>
          <div style="width:30%;margin-bottom:20px">

            <button id="pdf_open">Open PDF</button>
          </div>
          <div id="viewport" role="main">

          </div>

        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('post-js')

<script type="text/javascript">
$(document).ready(function()
{
var currentPageIndex = 0;
var pdfInstance = null;
var totalPagesCount = 0;
function initPDFViewer(pdfURL)
{
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

  var loadingTask = pdfjsLib.getDocument(pdfURL);
  console.log(loadingTask);
  loadingTask.promise.then(function(pdf) {
    pdfInstance = pdf;
    // console.log(pdfInstance);
    totalPagesCount = pdf.numPages;
    console.log(totalPagesCount);
    // initPager();
    render();
  });
  // pdfjsLib.getDocument(pdfURL).then(function(pdf) {
  //   pdfInstance = pdf;
  //   totalPagesCount = pdf.numPages;
  //   initPager();
  //   render();
  // });

}

var viewport = document.querySelector('#viewport');
// console.log(viewport);

function render() {
  var pdfinstant = pdfInstance.getPage(currentPageIndex + 1).then(function(page){
      viewport.innerHTML = `<div><canvas></canvas></div>`
      renderPage(page)
    })
}
function renderPage(page) {
  var pdfViewport = page.getViewport(1);
  console.log(pdfViewport);
  var container = viewport.children[0];
  //console.log(container);
  // Render at the page size scale.
  pdfViewport = page.getViewport(container.offsetWidth / pdfViewport.width);
  // console.log(pdfViewport);
  var canvas = container.children[0];
  var context = canvas.getContext("2d");
  canvas.height = pdfViewport.height;
  canvas.width = pdfViewport.width;

  // console.log(canvas);
  var renderContext =
  {
  canvasContext: context,
  viewport: pdfViewport
};
  page.render(renderContext);
}

  $('#pdf_open').click(function()
  {
    // initPDFViewer("{{ asset('files/sample.pdf') }}");

    //renderPDF("{{ asset('files/sample.pdf') }}", document.getElementById('pdf_viewer'));

    var pdf_obj = "<embed src='{{ asset('files/sample.pdf') }}' width='100%' height='700' type='application/pdf'>";
    $('#viewport').html(pdf_obj);
    // //getMediaStream();
    // //takePhoto();
    start_face_detection();
  });



});
function start_face_detection()
{
  Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceLandmark68Net.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceRecognitionNet.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceExpressionNet.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.ageGenderNet.loadFromUri("{{ asset('models') }}"),


  ]).then(startup);

}


var width = 320;    // We will scale the photo width to this
var height = 0;

function startup()
{
  var streaming = false;
  var video = null;
  var canvas = null;
  var photo = null;

  var startbutton = null;
  video = document.getElementById('video');
  canvas = document.getElementById('canvas');
  photo = document.getElementById('photo');
  startbutton = document.getElementById('startbutton');

  navigator.mediaDevices.getUserMedia({
    audio: false,
    video : {
      width: 320,
      height: 240
    }

  })
  .then(function(stream) {
    video.srcObject = stream;
    video.play();
  })
  .catch(function(err) {
    console.log("An error occurred: " + err);
  });

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      const canvas = faceapi.createCanvasFromMedia(video);

      $('#camera').append(canvas);
      const displaySize = {width: 320, height: 240};
      var time = 0;
      setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
        .withFaceLandmarks().withFaceExpressions().withFaceDescriptors();
        if (!detections)
        {
          throw new Error(`no faces detected for`);
        }
        const results = detections.map(function (fd) {
        //return { faceMatcher: faceMatcher.findBestMatch(fd['descriptor']), faceExpressions: fd['expressions'] }
        return { faceExpressions: fd['expressions'] }
      })
      if(results)
      {
        // console.log(results);
        var max_expression_key;
        results.forEach((bestMatch, i) =>
        {
          let expression = bestMatch['faceExpressions'];
          //let recognize = bestMatch['faceMatcher'].toString().split(" ")[0]
          // let max = Math.max.apply(null, Object.values(expression))
          var max = Math.max.apply(null,Object.keys(expression).map(function(x){ return expression[x] }));
          max_expression_key = Object.keys(expression).filter(function(x){ return expression[x] == max; })[0];
          console.log(max_expression_key);

        })
        const resizedDetections = faceapi.resizeResults(detections, displaySize)
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
        faceapi.draw.drawDetections(canvas, resizedDetections)
        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
        const minProbability = 0.05
        faceapi.draw.drawFaceExpressions(canvas, resizedDetections, minProbability)
        // console.log(max_expression_key);
        if (max_expression_key)
        {
          takepicture(max_expression_key);
        }


      }


//       document.addEventListener("visibilitychange", function() {
//       if (document.hidden) {
//
//         console.log("Hidden");
//       }
//       else {
//
//
//       }
// });


},3000);


      // video.setAttribute('width', 320);
      // video.setAttribute('height', 240);
      // canvas.setAttribute('width', 320);
      // canvas.setAttribute('height', 240);
      // streaming = true;
    }
  }, false);

  // setInterval(async () =>
  // {
  //
  //   // preventDefault();
  // }, 10000)


  // startbutton.addEventListener('click', function(ev){
  //   takepicture();
  //   ev.preventDefault();
  // }, false);

  //clearphoto();

}

function clearphoto() {
  var context = canvas.getContext('2d');
  context.fillStyle = "#AAA";
  context.fillRect(0, 0, canvas.width, canvas.height);

  var data = canvas.toDataURL('image/png');
  photo.setAttribute('src', data);
}

function takepicture(max_expression)
{
  var context = canvas.getContext('2d');
  if (width && height)
  {
    canvas.width = width;
    canvas.height = height;
    context.drawImage(video, 0, 0, width, height);

    var data = canvas.toDataURL('image/png');
    // console.log(data);
    photo.setAttribute('src', data);
    var pic_data = document.getElementById("canvas").toDataURL("image/jpg");
    doUpload(max_expression,pic_data);
  } else {
    clearphoto();
  }
}

function doUpload(max_expression, pic_data)
{
  var Pic = pic_data.replace(/^data:image\/(png|jpg);base64,/, "");
  // console.log(max_expression);
}

</script>

@endpush
