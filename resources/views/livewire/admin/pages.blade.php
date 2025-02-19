<div>

    <div class="pd-20 card-box mb-30">

        <div class="table-responsive">

            <table class="table table-striped table-auto table-sm">

                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Show on header</th>
                    <th scope="col">Show on footer</th>
                    <th scope="col">Action</th>
                </thead>

                <tbody id="sortable_pages">

                    @forelse ( $pages as $item )

                        <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                            <td scope="row">{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <div>
                                    <input wire:click="updateVisibility('header',{{$item->id}})" type="checkbox" class="switch-btnx" data-color="#0099ff" id="vh_{{$item->id}}" {{ $item->show_on_header ? 'checked' : '' }} />
                                </div>



                            </td>
                            <td>
                                <input wire:click="updateVisibility('footer',{{$item->id}})" type="checkbox" class="switch-btnx" data-color="#0099ff" id="vf_{{$item->id}}" {{ $item->show_on_footer ? 'checked' : '' }} />

                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.edit_page',['id'=>$item->id]) }}" data-color="#265ed7" style="color: rgb(38, 94, 215)">
                                        <i class="icon-copy dw dw-edit2"></i>
                                    </a>
                                    <a href="javascript:;" wire:click="$dispatch('deletePage',{ id:{{$item->id}} })" data-color="#e95959" style="color: rgb(233, 89, 89)">
                                        <i class="icon-copy dw dw-delete-3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <span class="text-danger">No page(s) found!</span>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- pagination --}}
        <div class="block mt-1">
            {{ $pages->links('livewire::simple-bootstrap') }}
        </div>

    </div>

</div>
