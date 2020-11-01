<template>
    <div class="row">
        <div id="webviewer" ref="viewer"></div>
    </div>
</template>

<script>
    import WebViewer from '@pdftron/webviewer';
    export default {
        props: ['book'],
        data(){
            return {
                total_pages : 0,
                current_page: 1
            }
        },
        mounted() {
        this.loadBook();
        },
        methods: {
            loadBook(){
                const obj_book = this.book;
                const pdf_path = window.Laravel.baseUrl+'/uploads/books/'+obj_book.book_file;
                const path = window.Laravel.baseUrl+'/webviewer';
                const viewer = this.$refs.viewer;
                WebViewer({licenseKey:null,fullAPI: true, path, initialDoc: pdf_path }, viewer).then(function(instance) {
                    instance.setTheme('dark');
                    const { docViewer,annotManager, PDFNet } = instance;

                    function openBookReading(current_page,total_pages){

                        axios.post('/api/v1/open-book-reading-track',{
                            book_id:obj_book.book_id,
                            current_page:current_page,
                            total_pages:total_pages
                        })
                            .then((response) => {
                                console.log(response.data.message);
                            }, (error) => {
                                console.log(error);
                            });

                    }
                    function bookReading(current_page,total_pages){

                        axios.post('/api/v1/book-reading-track',{
                            book_id:obj_book.book_id,
                            current_page:current_page,
                            total_pages:total_pages
                        })
                            .then((response) => {
                                console.log(response.data.message);
                            }, (error) => {
                                console.log(error);
                            });

                    }
                    console.log(docViewer);
                    docViewer.on('pageNumberUpdated', (pageNumber) => {
                        console.log("pageNumberUpdated");
                        console.log(pageNumber);
                        bookReading(pageNumber,docViewer.getPageCount());
                    });
                    docViewer.on('visiblePagesChanged', (pageNumber,canvas) => {
                        console.log("visiblePagesChanged");
                        console.log(pageNumber,canvas);
                    });
                    docViewer.on('documentLoaded', async () => {
                        const doc = docViewer.getDocument();
                        //this.total_pages = docViewer.getPageCount();
                        console.log("Total Pages: " + docViewer.getPageCount())
                        // call methods relating to the loaded document
                        console.log("documentLoaded");
                        var total_pages = docViewer.getPageCount();
                        if(total_pages>0)
                            openBookReading(1,total_pages);
                    });


                });
                return {
                    viewer,
                };

            },
            getBook(){
                axios.get(`/api/books/${this.book.book_id}`)
                    .then((response) => {
                        if(response.data.status) {

                        }else{
                            console.log(response.data.message);
                        }
                    }, (error) => {
                        console.log(error);
                    });
            },




        }
    }
</script>

<style scoped>
#webviewer{
    height: 800px;
    width: 100% !important;
}
</style>