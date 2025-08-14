@extends("dashboard.master")
@section('title', isset($role) ? __('keys.edit_role') : __('keys.add_role'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong
                                class="card-title">{{ isset($role) ? __('keys.edit_role') : __('keys.add_role') }}</strong>
                    </div>
                    <div class="card-body">
                        @include('dashboard.roles.form', [
                            "route" => isset($role) ?  route('admin.roles.update', ['role' => $role->id]) : route('admin.roles.store') ,
                            "role" => $role ?? null,
                            "method" => isset($role) ? "PUT" : "POST",
                            "permissions" => $permissions
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_script')
    <script>
        $(document).ready(function () {
            $(".toggle-permissions").each(function () {
                const target = $(this).data("target");
                const hasChecked = $(target).find("input[type='checkbox']:checked").length > 0;

                if (hasChecked) {
                    $(target).show();
                    $(this).text("{{ __('keys.hide_permissions') }}");
                    $(this).attr("aria-expanded", "true");
                } else {
                    $(target).hide();
                    $(this).text("{{ __('keys.show_permissions') }}");
                    $(this).attr("aria-expanded", "false");
                }
            });

            $(".toggle-permissions").click(function () {
                const target = $(this).data("target");
                const isExpanded = $(this).attr("aria-expanded") === "true";

                $(this).attr("aria-expanded", !isExpanded);
                $(target).slideToggle();

                $(this).text(
                    isExpanded ? "{{ __('keys.show_permissions') }}" : "{{ __('keys.hide_permissions') }}"
                );
            });

            // Handle "Select All" functionality
            $(".select-all-checkbox").change(function () {
                const groupId = $(this).attr("id").replace("selectAll-", "");
                const checkboxes = $("#permissions-" + groupId).find(".permission-checkbox");

                checkboxes.prop("checked", $(this).prop("checked"));
            });

            // Uncheck "Select All" if any permission is manually unchecked
            $(".permission-checkbox").change(function () {
                const groupId = $(this).closest(".permissions-list").attr("id").replace("permissions-", "");
                const allChecked = $("#permissions-" + groupId).find(".permission-checkbox:checked").length ===
                    $("#permissions-" + groupId).find(".permission-checkbox").length;

                $("#selectAll-" + groupId).prop("checked", allChecked);
            });
            // Check if all permissions in each group are selected and mark "Select All" as checked
            $(".permissions-list").each(function () {
                const groupId = $(this).attr("id").replace("permissions-", "");
                const allChecked = $(this).find(".permission-checkbox:checked").length ===
                    $(this).find(".permission-checkbox").length;

                $("#selectAll-" + groupId).prop("checked", allChecked);
            });
        });


    </script>
@endsection
