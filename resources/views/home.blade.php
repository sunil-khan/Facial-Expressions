@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Books</div>

        <div class="card-body">
          <div class="row">
            <div class="camera">
              <video id="video">Video stream not available.</video>


            </div>
            <canvas id="pic_canvas">
            </canvas>

          </div>
          <div class="row">

            <div class="col-md-3">
              <div class="book_img">
                <img src="{{ asset('files/pdf.png') }}" alt="" height="100" width="80">

              </div>
              <div class="book_title">
                <a href="#" title="sample" onclick="open_pdf(this.title)">Sample Book</a>

              </div>
            </div>
            <div class="col-md-3">
              <div class="book_img">
                <img src="{{ asset('files/pdf.png') }}" alt="" height="100" width="80">

              </div>
              <div class="book_title">
                <a href="#" onclick="open_pdf(this.title)" title="Living in the Light_ A guide to personal transformation">Living in the Light_ A guide to personal transformation</a>

              </div>
            </div>

          </div>

          <div class="row" id="pdfrender" role="main">
            <div class="col-md-12">
              <button id="prev">Previous</button>
              <button id="next">Next</button>
              &nbsp; &nbsp;
              <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
            </div>

            <canvas id="the-canvas"></canvas>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('post-scripts')

<script type="text/javascript">

var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

var pdfDoc = null,
pageNum = 1,
pageRendering = false,
pageNumPending = null,
scale = 0.8;
const canvas = document.getElementById('the-canvas');
ctx = canvas.getContext('2d');
window.devicePixelRatio=2;
canvas.font = "18px Comic Sans MS";
var size = 150;
canvas.style.width = "55em";
canvas.style.height = "76em";
var scale = window.devicePixelRatio;

canvas.width = Math.floor(size * scale);
canvas.height = Math.floor(size * scale);
ctx.scale(scale, scale);
ctx.font = '12px Arial';
ctx.textAlign = 'center';
ctx.textBaseline = 'middle';
function open_pdf(book_title)
{
  var book_ti = book_title;
  var pdf_url = "{{ asset('files/sample.pdf') }}";
  // var pdf_obj = "<embed src='{{ asset('files/sample.pdf') }}' width='100%' height='700' type='application/pdf'>";
  // $('#pdfrender').html(pdf_obj);
  $('html, body').animate({
    scrollTop: $("#pdfrender").offset().top
  }, 2000);

  pdfjsLib.getDocument(pdf_url).promise.then(function(pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;
    renderPage(pageNum);
  });

  // loadPDFJS();
  start_face_detection();

}

function renderPage(num)
{
  // alert('hello');
  pageRendering = true;
  // Using promise to fetch the page
  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport({scale: scale});
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);

    // Wait for rendering to finish
    renderTask.promise.then(function() {
      pageRendering = false;
      if (pageNumPending !== null) {
        // New page rendering is pending
        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });
  // console.log(num);
  // Update page counters
  document.getElementById('page_num').textContent = num;
}

/**
* If another page rendering in progress, waits until the rendering is
* finised. Otherwise, executes rendering immediately.
*/
function queueRenderPage(num)
{
  //
  if (pageRendering)
  {
    pageNumPending = num;

  } else {
    renderPage(num);
  }

  ret_page_number(num);
  // startup(num);
}
function ret_page_number(page_num)
{
  return page_num;
}

/**
* Displays previous page.
*/
function onPrevPage()
{
  if (pageNum <= 1) {
    return;
  }
  pageNum--;
  queueRenderPage(pageNum);
}
document.getElementById('prev').addEventListener('click', onPrevPage);

/**
* Displays next page.
*/
function onNextPage() {

  if (pageNum >= pdfDoc.numPages)
  {
    return;
  }
  pageNum++;
  queueRenderPage(pageNum);
}
document.getElementById('next').addEventListener('click', onNextPage);




//Face Detection starts here

function start_face_detection()
{
  Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceLandmark68Net.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceRecognitionNet.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.faceExpressionNet.loadFromUri("{{ asset('models') }}"),
    faceapi.nets.ageGenderNet.loadFromUri("{{ asset('models') }}"),


  ]);
  startup();

}

var width = 320;    // We will scale the photo width to this
var height = 0;

function startup()
{
  // console.log(pagenumber);
  var streaming = false;
  var video = null;
  var canvas = null;
  var photo = null;

  var startbutton = null;
  video = document.getElementById('video');
  pic_canvas = document.getElementById('pic_canvas');
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
      // const canvas = faceapi.createCanvasFromMedia(video);

      // $('#camera').append(canvas);
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
            // console.log(max_expression_key);

          })
          // const resizedDetections = faceapi.resizeResults(detections, displaySize)
          // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
          // faceapi.draw.drawDetections(canvas, resizedDetections)
          // faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
          // const minProbability = 0.05
          // faceapi.draw.drawFaceExpressions(canvas, resizedDetections, minProbability)
          // console.log(max_expression_key);
          if (max_expression_key)
          {
            // var get_page_number = ret_page_number();
            // console.log(get_page_number);
            takepicture(max_expression_key,get_page_number);
          }


        }



      },5000);

    }
  }, false);



}

function clearphoto() {
  var context = pic_canvas.getContext('2d');
  context.fillStyle = "#AAA";
  context.fillRect(0, 0, pic_canvas.width, pic_canvas.height);

  var data = pic_canvas.toDataURL('image/png');
  photo.setAttribute('src', data);
}

function takepicture(max_expression,pagenumber)
{
  var context = pic_canvas.getContext('2d');
  if (width && height)
  {
    pic_canvas.width = width;
    pic_canvas.height = height;
    context.drawImage(video, 0, 0, width, height);

    var pic_data = pic_canvas.toDataURL('image/jpeg', 1.0);


    doUpload(max_expression,pic_data,pagenumber);
  } else {
    clearphoto();
  }
}



// Ajax function to store data in DB

function doUpload(max_expression, pic_data, page_nbr)
{
  

  $.ajax({
    url: "/saveExpressions",
    method: "POST",
    data: {'facial_expression':max_expression,'_token': "{{ csrf_token() }}",'pic_data':pic_data,'page_number':page_nbr},
    dataType: 'json',
    success:function(data)
    {
      if (data['status'] == true)
      {

      }
      else
      {

      }


    }
  });
}

document.addEventListener('visibilitychange', function(){

});

</script>

<script defer src="{{ asset('js/face-api.js') }}"></script>

@endpush
