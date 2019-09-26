<template>
    <div>
        <h1 class="mt-5">
            Adverts
            <small class="float-right d-flex flex-row justify-content-center align-items-center">
                <small class="limits mr-2 ml-2">
                    <label for="limit">Items on page:</label>
                    <select id="limit" @change="changeLimit()" v-model="itemsPerPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                    </select>
                </small>

                <small class="mr-2 ml-2" v-if="app_data.user && app_data.user.id > 0">
                    <button class="btn btn-sm btn-outline-primary" id="add-new-advert" @click="addAdvert()">Add new</button>
                </small>
            </small>
        </h1>
        <div class="media text-muted pt-3 pb-3 d-flex flex-column flex-md-row border-top border-gray"
             v-for="advert in adverts">
            <div class="d-flex flex-column pt-2 pb-2 pr-3 advert-user">
                <img :src="advert.user.image" :alt="advert.user.name" v-show="advert.user.image" class="advert-user-image img-thumbnail">
                <strong class="d-block text-gray-dark" v-text="advert.user.name"></strong>
                <span v-text="advert.user.email"></span>
                <span v-text="advert.user.phone"></span>
            </div>
            <div class="media-body pt-2 pb-2 pl-3 mb-0 d-flex flex-column justify-content-between align-items-stretch w-100">
                <h4 v-text="advert.title"></h4>
                <p v-text="advert.description"></p>
                <div class="">
                    <div class="float-left">
                        <span v-text="advert.created_at"></span>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-outline-warning"
                                @click="editAdvert(advert.id)"
                                v-if="app_data.user && advert.user_id == app_data.user.id ">Edit
                        </button>
                        <button type="button" @click="deleteAdvert(advert.id)" class="btn btn-sm btn-outline-danger"
                                v-if="app_data.user && advert.user_id == app_data.user.id ">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="app_data.user && app_data.user.id > 0">
            <div v-show="isModalShowed">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-text="currentAdvertAction === 'create' ? 'Add new advert' : 'Edit advert'"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                @click="closeModal()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title"
                                                       aria-describedby="titleHelp" placeholder="Enter title"
                                                       :class="{'is-invalid': currentAdvertErrors.title}"
                                                       v-model="currentAdvert.title">
                                                <div class="invalid-feedback" v-show="currentAdvertErrors.title"
                                                     v-text="currentAdvertErrors.title"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" class="form-control"
                                                          placeholder="Enter description" rows="6"
                                                          :class="{'is-invalid': currentAdvertErrors.description}"
                                                          v-model="currentAdvert.description"></textarea>
                                                <div class="invalid-feedback" v-show="currentAdvertErrors.description"
                                                     v-text="currentAdvertErrors.description"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close </button>
                                        <button type="button" class="btn btn-primary"
                                                :disabled="isSendDisabled"
                                                @click="trottledStoreAdvert()"
                                                v-text="currentAdvertAction === 'create' ? 'Store' : 'Update'"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import AdvertClient from '../api/client';

    import { throttle } from 'lodash';

    const trottledDelay = 1000;

    export default {
        mounted() {
            this.getList();
        },

        data() {
            return {
                app_data: window.app_data || [],
                adverts: [],
                isModalShowed: false,
                isSendDisabled:false,
                currentAdvertAction: 'create',
                currentAdvert: {},
                currentAdvertErrors: {},
                itemsPerPage: 10
            }
        },

        methods: {
            changeLimit(){
                this.getList();
            },

            getList() {
                AdvertClient.list({
                    limit: this.itemsPerPage
                })
                .then((result) => {
                    if (result.data.status === 'success') {
                        this.adverts = result.data.data.adverts
                    } else {
                        console.error('Error: cant get advert data');
                    }
                })
                .catch((err) => {
                    console.error(err.toString())
                });
            },

            closeModal() {
                this.currentAdvert = {};
                this.currentAdvertErrors = {};
                this.isModalShowed = false;
            },

            addAdvert() {
                this.currentAdvert = {
                    title: '',
                    description: '',
                };
                this.currentAdvertAction = 'create';
                this.currentAdvertErrors = {};
                this.isModalShowed = true;
            },

            validateStore() {

                this.currentAdvertErrors = {};

                let is_title_valid = this.currentAdvert.title !== '';
                let is_description_valid = this.currentAdvert.description !== '';

                if (!is_title_valid) {
                    this.currentAdvertErrors.title = 'Please type advert title!';
                }

                if (!is_description_valid) {
                    this.currentAdvertErrors.description = 'Please type advert description!';
                }

                return is_title_valid && is_description_valid;
            },

            trottledStoreAdvert() {
                this.isSendDisabled = true;
                throttle(this.storeAdvert, trottledDelay)();
            },

            storeAdvert() {
                if (this.validateStore()) {

                    if(this.currentAdvertAction === 'create'){

                        AdvertClient.store({
                            title: this.currentAdvert.title,
                            description: this.currentAdvert.description,
                        })
                        .then(() => {
                            this.closeModal();
                            this.getList();
                            this.isSendDisabled = false;
                        })
                        .catch((err) => {
                            console.error(err.toString())
                        });

                    } else if (this.currentAdvertAction === 'edit'){

                        AdvertClient.update({
                            title: this.currentAdvert.title,
                            description: this.currentAdvert.description,
                            id: this.currentAdvert.id,
                        })
                        .then(() => {
                            this.closeModal();
                            this.getList();
                            this.isSendDisabled = false;
                        })
                        .catch((err) => {
                            console.error(err.toString())
                        });
                    }

                } else {
                    this.isSendDisabled = false;
                }
            },

            editAdvert(id) {
                AdvertClient.show(id)
                    .then((result) => {
                        if(result.data.status === 'success'){
                            this.currentAdvert = result.data.data.advert;
                            this.currentAdvertAction = 'edit';
                            this.currentAdvertErrors = {};
                            this.isModalShowed = true;
                        }
                    })
                    .catch((err) => {
                        console.error(err.toString())
                    });
            },

            deleteAdvert(id) {
                AdvertClient.delete(id)
                    .then(() => {
                        this.getList();
                    })
                    .catch((err) => {
                        console.error(err.toString())
                    });
            }
        }
    }
</script>

<style>
    .limits {
        font-size: 1rem;
        line-height: 0;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .advert-user {
        align-items: flex-start;
    }

    @media(max-width: 767px){
        .advert-user {
            width: 100%;
            align-items: center;
        }
    }

    .advert-user-image {
        width: 100px;
        height: auto;
    }
</style>