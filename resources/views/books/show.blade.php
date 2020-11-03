@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Title: {{ $book->book_title }}, Author Name: {{ $book->book_author_name }}</div>
                    <div class="card-body">
                        <div class="row">
                        <div id="my_pdf_viewer">
                            <div id="canvas_container">
                                <canvas id="pdf_renderer" style="border: 1px solid black; direction: ltr;"></canvas>

                                <div id="navigation_controls">
                                    <button id="go_previous">Previous</button>
                                    <input id="current_page" value="{{ isset($book->UserBookReading->book_current_page)?$book->UserBookReading->book_current_page:1 }}" type="number"/>
                                    <button id="go_next">Next</button>
                                </div>
                                <div id="zoom_controls">
                                    <button id="zoom_in">+</button>
                                    <button id="zoom_out">-</button>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <div id="camera_div" class="camera">
                                <video id="video">Video stream not available.</video>
                                <canvas id="pic_canvas">
                                </canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('post-styles')
    <style>
        #my_pdf_viewer, #camera_div{
            margin: 0 auto;
        }
        #camera_div{
            margin-top: 20px;
        }
        #canvas_container {
            width: 100%;
            height: 100%;
            overflow: auto;
        }
    </style>

@endpush

@push('post-scripts')

    <script src="{{ asset('js/pdfjs/build/pdf.js') }}"></script>
    <script src="{{ asset('js/face-api.js') }}"></script>


    <script>
        var myState = {
            book_id:{{ $book->book_id }},
            pdf: null,
            currentPage: {{ isset($book->UserBookReading->book_current_page)?$book->UserBookReading->book_current_page:1 }},
            zoom: 1.5
        };
        var pdf_url = '{{ asset('uploads/books/'.$book->book_file) }}';
        pdfjsLib.GlobalWorkerOptions.workerSrc ='{{ asset('js/pdfjs/build/pdf.worker.js') }}';


        pdfjsLib.getDocument(pdf_url).promise.then((pdf) => {
            myState.pdf = pdf;
            render();
        });

        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var scale = 1.5;
                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');
                var viewport = page.getViewport({scale: myState.zoom});
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });

                bookReadingTrack();

            });
        }

        document.getElementById('go_previous')
            .addEventListener('click', (e) => {
                if(myState.pdf == null
                    || myState.currentPage == 1) return;
                myState.currentPage -= 1;
                document.getElementById("current_page")
                    .value = myState.currentPage;
                render();
            });

        document.getElementById('go_next')
            .addEventListener('click', (e) => {
                if(myState.pdf == null
                    || myState.currentPage > myState.pdf
                        ._pdfInfo.numPages)
                    return;

                myState.currentPage += 1;
                document.getElementById("current_page")
                    .value = myState.currentPage;
                render();
            });

        document.getElementById('current_page')
            .addEventListener('keypress', (e) => {
                if(myState.pdf == null) return;

                // Get key code
                var code = (e.keyCode ? e.keyCode : e.which);

                // If key code matches that of the Enter key
                if(code == 13) {
                    var desiredPage =
                        document.getElementById('current_page')
                            .valueAsNumber;

                    if(desiredPage >= 1
                        && desiredPage <= myState.pdf
                            ._pdfInfo.numPages) {
                        myState.currentPage = desiredPage;
                        document.getElementById("current_page")
                            .value = desiredPage;
                        render();
                    }
                }
            });

        document.getElementById('zoom_in')
            .addEventListener('click', (e) => {
                if(myState.pdf == null) return;
                myState.zoom += 0.5;
                render();
            });

        document.getElementById('zoom_out')
            .addEventListener('click', (e) => {
                if(myState.pdf == null) return;
                myState.zoom -= 0.5;
                render();
            });

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
                                takepicture(max_expression_key);
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

        function takepicture(max_expression)
        {
            var context = pic_canvas.getContext('2d');
            if (width && height)
            {
                pic_canvas.width = width;
                pic_canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var pic_data = pic_canvas.toDataURL('image/jpeg', 1.0);
               bookReadingExpression(max_expression,pic_data);
            } else {
                clearphoto();
            }
        }

        start_face_detection();

        function bookReadingTrack() {
            $.post('/api/v1/book-reading-track',{book_id:myState.book_id,current_page:myState.currentPage,total_pages:myState.pdf._pdfInfo.numPages},function(response){
                console.log(response);
            },"json");
        }

        function bookReadingExpression(max_expression,pic_data) {
            $.post('/api/v1/book-reading-expression',{book_id:myState.book_id,current_page:myState.currentPage,'pic_data':pic_data,'expression_type':max_expression},function(response){
                console.log(response);
            },"json");
        }


    </script>
@endpush