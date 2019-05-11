<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Room</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">Room</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Room</h4>

                        <div class="col-4 text-left">
                            <a href="room/create" class="btn btn-info btn-lg">Добавить новый номер</a>
                        </div>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" class="form-control" v-model="filterRoomForm.name" @blur="getRooms">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Sort By</label>
                                    <select name="sortBy" class="form-control" v-model="filterRoomForm.sortBy" @change="getRooms">
                                        <option value="name">Id</option>
                                        <option value="name">Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Order</label>
                                    <select name="order" class="form-control" v-model="filterRoomForm.order" @change="getRooms">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Room List</h4>
                        <h6 class="card-subtitle" v-if="rooms.total">Total {{rooms.total}} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table" v-if="rooms.total">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Город</th>
                                        <th>Address</th>
                                        <th>Тип</th>
                                        <th>Состояние</th>
                                        <th style="width:180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="room in rooms.data">
                                        <td v-text="room.id"></td>
                                        <td v-text="room.city_name"></td>
                                        <td v-text="room.address"></td>
                                        <td v-text="room.type_name"></td>
                                        <td v-text="room.condition_name"></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click.prevent="editRoom(room)" data-toggle="tooltip" title="Edit Room"><i class="fa fa-pencil"></i></button>
                                            <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteRoom(room)" data-toggle="tooltip" title="Delete Room"><i class="fa fa-trash"></i></button>
                                            </click-confirm>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="rooms" :limit=3 v-on:pagination-change-page="getRooms"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterRoomForm.pageLength" @change="getRooms" v-if="rooms.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RoomForm from './form'
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'

    export default {
        components : { RoomForm, pagination, ClickConfirm },
        data() {
            return {
                rooms: {},
                filterRoomForm: {
                    sortBy : 'id',
                    order: 'desc',
                    name: '',
                    pageLength: 5
                }
            }
        },

        created() {
            this.getRooms();
        },

        methods: {
            getRooms(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterRoomForm);
                axios.get('/api/room?page=' + page + url)
                    .then(response => this.rooms = response.data );
            },
            deleteRoom(room){
                axios.delete('/api/room/'+room.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getRooms();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editRoom(room){
                this.$router.push('/room/'+room.id+'/edit');
            },
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          }
        }
    }
</script>
