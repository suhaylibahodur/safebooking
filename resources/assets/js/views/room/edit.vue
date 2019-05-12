<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Edit Room</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/room">Room</router-link></li>
                    <li class="breadcrumb-item active">Edit Room</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Room</h4>
                        <div class="row justify-content-start float-left col-md-6">
                            <div class="col-md-12">
                                <room-form :id="id"></room-form>
                            </div>
                        </div>

                        <div class="row justify-content-end col-md-6">
                            <div class="card card-default col-md-12">
                                <div class="card-header">Добавить картинки</div>

                                <div class="card-body">
                                    <image-uploader :id="id"></image-uploader>
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
    import RoomForm from './form';
    import ImageUploader from '../images/image_uploader'
    import helper from '../../services/helper'

    export default {
        components : { RoomForm, ImageUploader },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>