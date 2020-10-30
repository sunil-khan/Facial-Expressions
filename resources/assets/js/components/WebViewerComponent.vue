<template>
    <div class="row">
        <div id="webviewer" ref="viewer"></div>
    </div>
</template>

<script>
    import WebViewer from '@pdftron/webviewer';
    export default {
        props: ['initial_doc','book'],
        mounted() {
            console.log(window.Laravel.baseUrl);
            const path = window.Laravel.baseUrl+'/webviewer';
            const viewer = this.$refs.viewer;
            WebViewer({licenseKey:null,fullAPI: true, path, initialDoc: 'files/sample.pdf' }, viewer).then(function(instance) {
                instance.setTheme('dark');
                const { docViewer,annotManager, PDFNet } = instance;

                console.log(docViewer);
                docViewer.on('pageNumberUpdated', (pageNumber) => {
                    console.log("pageNumberUpdated");
                    console.log(pageNumber);
                });
                docViewer.on('visiblePagesChanged', (pageNumber,canvas) => {
                    console.log("visiblePagesChanged");
                    console.log(pageNumber,canvas);
                });
                docViewer.on('documentLoaded', async () => {
                    const doc = docViewer.getDocument();

                    console.log("Total Pages: " + docViewer.getPageCount())
                    // call methods relating to the loaded document
                    console.log("documentLoaded");
                });


            });
            return {
                viewer,
            };
        },
        methods: {
            loadBook(){
                axios.get(`/api/books/${this.book.book_id}`)
                    .then((response) => {
                        if(response.data.status) {

                        }else{
                            console.log(response.data.message);
                        }
                    }, (error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>
#webviewer{
    height: 800px;
    width: 100% !important;
}
</style>