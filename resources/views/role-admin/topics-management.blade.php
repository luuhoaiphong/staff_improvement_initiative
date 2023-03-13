@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Topics management</h4>
                    </div>
                    <div class="table-responsive">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show col-md-5" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show col-md-5" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(session('success'))
                            <div class="alert alert-success alert-dismissible fade show col-md-5" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif --}}
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="position: sticky; left: 0; z-index: 1; background: white">Action</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Topic name</th>
                                    <th>Ideas count</th>
                                    <th>Topic Description</th>
                                    <th>First closure date</th>
                                    <th>Final closure date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $topic)
                                    <tr>
                                        <td style="position: sticky; left: 0; z-index: 1; background: white">
                                            <button type="button" class="btn btn-primary btn-sm" id="topic-edit-modal"
                                                data-id="{{ $topic->topic_id }}" data-topicName="{{ $topic->topic_name }}"
                                                data-description="{{ $topic->topic_description }}"
                                                data-firstClosureDate="{{ $topic->firstClosureDate }}"
                                                data-finalClosureDate="{{ $topic->finalClosureDate }}"
                                                data-categoryID="{{ $topic->category->category_name }}">Edit</button>
                                        </td>
                                        <td class="text-center font-weight-bold">
                                            @if (date('M-d-Y h:i:s a') > date('M-d-Y h:i:s a', strtotime($topic->firstClosureDate)))
                                                <span class="badge badge-danger text-black font-weight-bold">Closed</span>
                                            @else
                                                <span class="badge badge-success">Opening</span>
                                            @endif
                                        </td>

                                        <td title="{{ $topic->category->category_name }}"
                                            style="white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 150px; line-height: 1.5; text-align: justify">
                                            {{ $topic->category->category_name }}</td>
                                        <td>{{ $topic->topic_name }}</td>
                                        <td class="text-center font-weight-bold">{{ $topic->ideaPosts->count() }}</td>
                                        <td title="{{ $topic->topic_description }}"
                                            style=" white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 150px; line-height: 1.5; text-align: justify">
                                            {{ $topic->topic_description }}</td>
                                        <td class="font-weight-bold">
                                            {{ date('M-d-Y h:i:s a', strtotime($topic->firstClosureDate)) }}</td>
                                        <td class="font-weight-bold">
                                            {{ date('M-d-Y h:i:s a', strtotime($topic->finalClosureDate)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center align-items-center">
                            {{ $topics->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NOTE: Edit topic modal --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="topic-update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-sample" id="form-update-topic" method="POST" action="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">First closure date</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" id="firstClosureDate_edit"
                                                        name="firstClosureDate" class="form-control"
                                                        value="{{ old('firstClosureDate') }}">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Category name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="category_edit" name="category"
                                                        class="form-control" value="{{ old('category') }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Final closure date</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="datetime-local"
                                                        name="finalClosureDate" id="finalClosureDate_edit"
                                                        value="{{ old('finalClosureDate') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic name</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="topicName"
                                                        id="topicName_edit" value="{{ old('topicName') }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <button type="submit" class="btn btn-primary mr-2">Update the
                                                    topic deadline</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic description</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description" id="description_edit" value="{{ old('description') }}" class="form-control"
                                                        cols="30" rows="10" readonly style="line-height: 1.5"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //NOTE: passing value to update house modal
            var editTopicBtn = document.querySelectorAll('#topic-edit-modal');
            editTopicBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var topicID = e.getAttribute('data-id');
                    var topicName = e.getAttribute('data-topicName');
                    var description = e.getAttribute('data-description');
                    var firstClosureDate = e.getAttribute('data-firstClosureDate');
                    var finalClosureDate = e.getAttribute('data-finalClosureDate');
                    var categoryID = e.getAttribute('data-categoryID');

                    var inputTopicName = document.getElementById('topicName_edit');
                    var inputDescription = document.getElementById('description_edit');
                    var inputFirstClosureDate = document.getElementById('firstClosureDate_edit');
                    var inputFinalClosureDate = document.getElementById('finalClosureDate_edit');
                    var inputCategory = document.getElementById('category_edit');

                    inputTopicName.value = topicName;
                    inputDescription.value = description;
                    inputFirstClosureDate.value = firstClosureDate;
                    inputFinalClosureDate.value = finalClosureDate;
                    inputCategory.value = categoryID;


                    var formUpdateTopic = document.getElementById('form-update-topic');
                    formUpdateTopic.action = "{{ route('topic.update.deadline', ':id') }}"
                        .replace(':id', topicID);

                    $('#topic-update-modal').modal('show');
                });
            });
        });
    </script>
@endsection
