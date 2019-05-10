<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Edit RoomType</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/room_type">RoomType</router-link></li>
                    <li class="breadcrumb-item active">Edit RoomType</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit RoomType</h4>
                        <room-type-form :id="id"></room-type-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RoomTypeForm from './form';
    import helper from '../../services/helper'

    export default {
        components : { RoomTypeForm },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>