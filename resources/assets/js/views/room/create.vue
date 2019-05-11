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
                        <h4 class="card-title">Add new Room</h4>
                        <room-form></room-form>
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
