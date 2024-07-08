@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bars</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Bars</li>
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
                    <h3 class="card-title">Bars</h3>

                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">
                                    id
                                </th>
                                <th style="width: 20%">
                                    type
                                </th>
                                <th style="width: 30%">
                                    image
                                </th>
                                <th>
                                    title
                                </th>
                                <th style="width: 8%" class="text-center">
                                    latitude
                                </th>
                                <th style="width: 8%" class="text-center">
                                    longtitude
                                </th>
                                <th style="width: 8%"></th>
                                <th style="width: 8%" class="text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inactive as $bar)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <a>
                                            {{ $bar->type }}
                                        </a>
                                        <br />
                                    </td>
                                    <td>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                              

                                            <img src="{{  $bar->image }}" alt="Example Image" width="100px" height="100px">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $bar->title }}
                                    </td>
                                    <td>
                                        {{ $bar->latitude }}
                                    </td>
                                    <td>
                                        {{ $bar->longtitude }}
                                    </td>
                                    <td class="project-actions text-right">

                                    <td class="project-actions text-right">
                                        <form action="{{ route('bar.activate', $bar->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm">
                                                Activate Bar
                                            </button>
                                        </form>
                                    </td>
                                    <td class="project-actions text-right">
                                        <form action="{{ route('inactive.delete', $bar->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Permanent Delete
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
