<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCourse'}" class="btn btn-success">Create new Course</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Course list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="course, index in course">
                        <td>{{ course.name }}</td>
                        <td>{{ course.semester }}</td>
                        <td>{{ course.year }}</td>

                        <td>
                            <router-link :to="{name: 'editCourse', params: {id: course.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(course.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                course: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/course')
                .then(function (resp) {
                    app.course = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load courses");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Confirmation to Delete this Courses ?")) {
                    var app = this;
                    axios.delete('/api/v1/course/' + id)
                        .then(function (resp) {
                            app.course.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete courses");
                        });
                }
            }
        }
    }
</script>