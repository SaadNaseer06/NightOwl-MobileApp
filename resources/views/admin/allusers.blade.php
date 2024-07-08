@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Projects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 20%">
                                    User Name
                                </th>
                                <th style="width: 30%">
                                    Image
                                </th>
                                <th>
                                    Email
                                </th>
                                <!--<th style="width: 8%" class="text-center">-->
                                <!--    Status-->
                                <!--</th>-->
                                <th>
                                    Role
                                </th>
                                <th>
                                    Edit
                                </th>
                                <th>
                                    Delete
                                </th>
                                <!--<th style="width: 20%">-->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <a>
                                            {{ $user->username }}
                                        </a>
                                        <br />
                                        <small>
                                            Created at: {{ $user->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                              

                                            <img src="{{  $user->image }}" alt="Example Image" width="100px" height="100px">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <!--<td class="project-state">-->
                                    <!--    <span class="badge badge-success">Success</span>-->
                                    <!--</td>-->
                                    <td class="project-actions">
                                        <form action="{{ route('role.appoint', $user->id) }}" method="POST">
                                            @csrf
                                            @if($user->role == 'admin')
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    Remove from Admin
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-secondary btn-sm">
                                                    Appoint as Admin
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="project-actions">
                                        <form action="{{ route('edit.user', $user->id) }}" method="GET">
                                            {{-- @csrf --}}
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Edit
                                            </button>
                                        </form>
                                    </td>
                                    <td class="project-actions">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE') <!-- Add this line to override the method -->
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                    </td>
                            @endforeach
                            </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
