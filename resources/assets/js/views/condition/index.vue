<template>
	<div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Condition</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item active">Condition</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add new Condition</h4>
                        <condition-form @completed="getCities"></condition-form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Condition</h4>

                        <div class="row m-t-40">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input name="name" class="form-control" v-model="filterConditionForm.name" @blur="getCities">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Sort By</label>
                                    <select name="sortBy" class="form-control" v-model="filterConditionForm.sortBy" @change="getCities">
                                        <option value="name">Id</option>
                                        <option value="name">Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Order</label>
                                    <select name="order" class="form-control" v-model="filterConditionForm.order" @change="getCities">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Condition List</h4>
                        <h6 class="card-subtitle" v-if="cities.total">Total {{cities.total}} result found!</h6>
                        <h6 class="card-subtitle" v-else>No result found!</h6>
                        <div class="table-responsive">
                            <table class="table" v-if="cities.total">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th style="width:180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="condition in cities.data">
                                        <td v-text="condition.id"></td>
                                        <td v-text="condition.name"></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click.prevent="editCondition(condition)" data-toggle="tooltip" title="Edit Condition"><i class="fa fa-pencil"></i></button>
                                            <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                                <button class="btn btn-danger btn-sm" @click.prevent="deleteCondition(condition)" data-toggle="tooltip" title="Delete Condition"><i class="fa fa-trash"></i></button>
                                            </click-confirm>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-8">
                                    <pagination :data="cities" :limit=3 v-on:pagination-change-page="getCities"></pagination>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right">
                                        <select name="pageLength" class="form-control" v-model="filterConditionForm.pageLength" @change="getCities" v-if="cities.total">
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
    import ConditionForm from './form'
    import pagination from 'laravel-vue-pagination'
    import helper from '../../services/helper'
    import ClickConfirm from 'click-confirm'

    export default {
        components : { ConditionForm, pagination, ClickConfirm },
        data() {
            return {
                cities: {},
                filterConditionForm: {
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
                let url = helper.getFilterURL(this.filterConditionForm);
                axios.get('/api/condition?page=' + page + url)
                    .then(response => this.cities = response.data );
            },
            deleteCondition(condition){
                axios.delete('/api/condition/'+condition.id).then(response => {
                    toastr['success'](response.data.message);
                    this.getCities();
                }).catch(error => {
                    toastr['error'](error.response.data.message);
                });
            },
            editCondition(condition){
                this.$router.push('/condition/'+condition.id+'/edit');
            },
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          }
        }
    }
</script>
