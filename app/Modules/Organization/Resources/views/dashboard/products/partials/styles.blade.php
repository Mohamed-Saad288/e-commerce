<style>
    * {
        box-sizing: border-box;
    }
    /* Tab Styling */
    .nav-tabs {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 1rem 0;
        border-bottom: 2px solid #dee2e6;
    }
    .nav-tabs .nav-item {
        margin: 0;
    }
    .nav-tabs .nav-link {
        display: block;
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        color: #495057;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
    }
    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-color: #0d6efd;
        border-bottom: 2px solid #fff;
        color: #0d6efd;
        font-weight: 600;
    }
    /* Tab Content */
    .tab-content {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        min-height: 300px;
    }
    /* Form Controls */
    .form-label {
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control,
    .form-select {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath d='M2 5l6 6 6-6z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
    /* Invalid Feedback */
    .is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    /* Card */
    .card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 1.25rem;
    }
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 1rem;
        text-align: right;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    /* Variations */
    .variation-item {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .variation-item .card-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        cursor: pointer;
        user-select: none;
    }
    .variation-item .card-header:hover {
        background-color: #e9ecef;
    }
    .remove-variation {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    /* Collapsible Variation Styles */
    .variation-collapse-icon {
        transition: transform 0.3s ease;
        display: inline-block;
        margin-right: 0.5rem;
    }

    .variation-collapse-icon.collapsed {
        transform: rotate(-90deg);
    }

    .variation-body {
        transition: max-height 0.3s ease, opacity 0.3s ease, padding 0.3s ease;
        max-height: 5000px;
        opacity: 1;
        overflow: hidden;
    }

    .variation-body.collapsed {
        max-height: 0;
        opacity: 0;
        padding: 0 !important;
    }

    .collapse-all-btn {
        font-size: 0.875rem;
        padding: 0.25rem 0.75rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
        .col-md-6, .col-md-4, .col-md-3 {
            width: 100%;
            margin-bottom: 0.75rem;
        }
    }
    /* Hide Template */
    #variationTemplate {
        display: none;
    }
    /* Image Upload Styling */
    .image-upload-container {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s;
    }
    .image-upload-container:hover {
        border-color: #0d6efd;
        background-color: #e7f3ff;
    }
    .image-upload-container input[type="file"] {
        display: none;
    }
    .image-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .image-preview-item {
        position: relative;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        overflow: hidden;
        aspect-ratio: 1;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        background-color: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 0.875rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    .image-preview-item .remove-image:hover {
        background-color: #dc3545;
    }
    .images-disabled-notice {
        background-color: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        color: #856404;
    }

    /* Category Selects Styling */
    #category-selects-container .category-level {
        min-width: 200px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    #category-path {
        min-height: 24px;
        line-height: 24px;
    }

    .category-select {
        font-size: 0.9rem;
    }


    .variation-header {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .variation-header:hover {
        background-color: #f8f9fa !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .remove-variation {
        transition: all 0.2s ease;
    }
    .remove-variation:hover {
        background-color: #dc3545 !important;
        color: white !important;
        transform: scale(1.1);
    }


    /* أزرار الـ Variations الجديدة - أشيك بمليون مرة */
    #collapseAllVariations,
    #expandAllVariations,
    #clearAllVariations {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    #collapseAllVariations:hover { background-color: #0d6efd; color: white; transform: scale(1.1); }
    #expandAllVariations:hover   { background-color: #0d6efd; color: white; transform: scale(1.1); }
    #clearAllVariations:hover    { background-color: #dc3545; color: white; transform: scale(1.1); }

    #addVariation {
        border-radius: 50px !important;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
    }

    #addVariation:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3) !important;
    }

    /* عداد عدد النسخ (بونص مجاني) */
    .variations-counter {
        background: linear-gradient(135deg, #6f42c1, #e83e8c);
        color: white;
        font-weight: bold;
        font-weight: bold;
        border-radius: 50px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(111, 66, 193, 0.4);
    }
</style>
