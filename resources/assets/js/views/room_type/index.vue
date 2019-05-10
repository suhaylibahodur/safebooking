<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">RoomType</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">RoomType</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add new RoomType</h4>
                        <room-type-form @completed="getCities"></room-type-form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter RoomType</h4>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" class="form-control" v-model="filterRoomTypeForm.name" @blur="getCities">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Sort By</label>
                                    <select name="sortBy" class="form-control" v-model="filterRoomTypeForm.sortBy" @change="getCities">
                                        <option value="name">Id</option>
                                        <option value="name">Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Order</label>
                                    <select name="order" class="form-control" v-model="filterRoomTypeForm.order" @change="getCities">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">RoomType List</h4>
                        <h6 class="card-subtitle" v-if="room_types.total">Total {{room_types.total}} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table" v-if="room_types.total">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th style="width:180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="roomType in room_types.data">
                                        <td v-text="roomType.id"></td>
                                        <td v-text="roomType.name"></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click.prevent="editRoomType(roomType)" data-toggle="tooltip" title="Edit RoomType"><i class="fa fa-pencil"></i></button>
                                            <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteRoomType(roomType)" data-toggle="tooltip" title="Delete RoomType"><i class="fa fa-trash"></i></button>
                                            </click-confirm>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="room_types" :limit=3 v-on:pagination-change-page="getCities"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterRoomTypeForm.pageLength" @change="getCities" v-if="room_types.total">
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
    import RoomTypeForm from './form'
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'

    export default {
        components : { RoomTypeForm, pagination, ClickConfirm },
        data() {
            return {
                room_types: {},
                filterRoomTypeForm: {
                    sortBy : 'id',
                    order: 'desc',
                    name: '',
                    pageLength: 5
                }
            }
        },

        created() {
            this.getCities();
        },

        methods: {
            getCities(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filterRoomTypeForm);
                axios.get('/api/room_type?page=' + page + url)
                    .then(response => this.room_types = response.data );
            },
            deleteRoomType(roomType){
                axios.delete('/api/room_type/'+roomType.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getCities();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editRoomType(roomType){
                this.$router.push('/room_type/'+roomType.id+'/edit');
            },
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          }
        }
    }
</script>
