<template>
    <div class="container col-md-12 row">
       <div class="col-md-4">
          <form action="">
              <h3>Create Book</h3><hr>
        <notifications position="top center" />
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Title</label>
                    <input type="text" class="form-control form-control-xs" v-model="book.title">
                </div>

                <div class="form-group col-md-12">
                    <label>Volume</label>
                    <input type="text" class="form-control form-control-xs" v-model="book.volume">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>year</label>
                    <input type="number" class="form-control form-control-xs" v-model="book.year">
                </div>

                <div class="form-group col-md-12">
                    <label>Genre</label>
                    <input type="text" class="form-control form-control-xs" v-model="book.genre">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" @click.prevent="saveBook" :disabled="loading">
                        <span class="icon s7-diskette"></span>
                        <img src="/assets/loaders/Spinner.svg" alt="loading" v-if="loading"> Save
                    </button>
                    <button class="btn btn-danger" @click.prevent="book = {}"><span class="icon s7-close-circle"></span> Clear</button>
                </div>
            </div>
        </form>
       </div>

       <div class="col-md-7">
             <div class="panel-heading">
                All Books
                <div class="tools">
                    <span class="icon s7-refresh-2" @click.prevent="fetchAllBooks"></span>
                </div>
            </div>
            <div class="panel-body">
                <div v-if="viewallLoading">
                </div>
                <div v-if="!viewallLoading">
                    <table class="table table-striped table-borderless" v-if="books.length > 0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width:40%;">Title</th>
                            <th>Volume</th>
                            <th>Author</th>
                            <th class="number">Genre</th>
                            <th class="number">Year</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="no-border-x">
                        <tr v-for="(book, index) in books">
                            <td>{{ ++index }}</td>
                            <td>{{book.title}}</td>
                            <td>{{book.volume}}</td>
                            <td>{{book.author.name}}</td>
                            <td>{{book.genre}}</td>
                            <td>{{book.year}}</td>
                            <td>
                                <button v-if="book.author.id == user.id" class="icon text-danger btn btn-small" @click.prevent="deleteBook(book)">delete</button>
                                <button v-if="book.author.id != user.id" class="icon text-danger btn btn-small" disabled @click.prevent="deleteBook(book)">delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-else="">
                        <p class="text-danger text-center">No Book found</p>
                    </div>
                </div>
            </div>
       </div>
    </div>
</template>

<script>
    import {apiDomain} from '../env.js';
    export default{
        data(){
            return {
                book: {},
                loading: false,
                viewallLoading: true,
                books:[],
                user:{}
            }
        },
        methods:{
            saveBook () {
                this.loading = true;
                axios.post(apiDomain + '/books/create', this.book).then(response => {
                    let $_response = response.data;
                    console.log("here", response);
                    if ($_response.status === 0) {
                        this.$notify({type: 'success', text: 'Book has been added successfully'});
                        this.fetchAllBooks();
                    } else {
                        this.$notify({type: 'error', text: 'Could not create add book. Please try again'});
                    }
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                    this.$notify({type: 'error', text: 'Could not create add book. Please try again'});
                })
            },

            fetchAllBooks() {
                this.viewallLoading = true;
                axios.get(apiDomain + '/books').then(response => {
                    let $_response = response.data;
                    console.log($_response);
                    if ($_response.status === 0) {
                        this.books = $_response.data;
                    } else {
                        this.$notify({type: 'error', text: 'Could not fetch books. Try reloading this page'});
                    }
                    this.viewallLoading = false;
                }).catch(error => {
                    this.viewallLoading = false;
                    this.$notify({type: 'error', text: 'Could not fetch books. Please try again'});
                })
            },

            getAuthUser(){
                axios.get(apiDomain + '/auth-user').then(response => {
                let $_response = response.data;
                    if ($_response) {
                        this.user = JSON.parse($_response.data);
                        console.log(this.user);
                    }
                }).catch(error => {
                    this.$notify({type: 'error', text: 'No authenticated user found.'});
                })
            },

            deleteBook(book){
                axios.delete(apiDomain + '/books/' + book.id).then(response => {
                    let $_response = response.data;
                    console.log($_response);
                    if ($_response.status === 0) {
                        this.$notify({type: 'success', text: 'Book has been deleted successfully'});
                        this.fetchAllBooks();
                    } else {
                        this.$notify({type: 'error', text: 'Could not delete books. Try reloading this page'});
                    }
                    this.viewallLoading = false;
                }).catch(error => {
                    this.viewallLoading = false;
                    this.$notify({type: 'error', text: 'Could not delete books. Please try again'});
                })
            }
        },
         mounted(){
            this.fetchAllBooks();
            this.getAuthUser();
        },
        components:{},
        props:[]
    }
</script>
