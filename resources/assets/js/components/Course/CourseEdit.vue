<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.courseId = id;
            axios.get('/api/v1/course/' + id)
                .then(function (resp) {
                    app.course = resp.data;
                })
                .catch(function () {
                    alert("Could not load your course")
                });
        },
        data: function () {
            return {
                courseId: null,
                course: {
                    name: '',
                    semester: '',
                    year: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newcourse = app.course;
                axios.patch('/api/v1/course/' + app.courseId, newcourse)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your course");
                    });
            }
        }
    }
</script>