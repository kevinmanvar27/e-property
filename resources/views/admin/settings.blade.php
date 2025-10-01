@extends('admin.layouts.app')

@section('styles')
<style>
    /* Custom styles for settings page */
    .settings-tabs {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 0;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid #e9ecef;
        position: sticky;
        top: 10px;
        z-index: 100;
    }
    
    .settings-tabs ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
    }
    
    .settings-tabs li {
        margin: 0;
    }
    
    .settings-tabs a {
        display: block;
        padding: 1rem 1.5rem;
        color: #495057;
        text-decoration: none;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.2s;
        font-weight: 500;
        border-bottom: 3px solid transparent;
    }
    
    .settings-tabs a:hover {
        background: #e9ecef;
        color: #0d6efd;
    }
    
    .settings-tabs a.active {
        background: white;
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        font-weight: 600;
    }
    
    .settings-section {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid #e9ecef;
        display: none;
    }
    
    .settings-section.active {
        display: block;
    }
    
    .settings-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #212529;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .settings-subtitle {
        font-size: 1.1rem;
        font-weight: 500;
        margin: 1.5rem 0 1rem;
        color: #495057;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #495057;
    }
    
    .setting-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .setting-col {
        flex: 1;
        min-width: 200px;
    }
    
    .color-setting {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .color-setting input[type="color"] {
        width: 50px;
        height: 38px;
        padding: 2px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .font-size-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .font-size-group input {
        width: 80px;
    }
    
    /* Typography settings in single row */
    .typography-settings-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.375rem;
        align-items: end;
    }
    
    .typography-setting {
        flex: 1;
        min-width: 150px;
    }
    
    .typography-setting .form-label {
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .typography-setting .color-setting {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .typography-setting .color-setting input[type="color"] {
        width: 50px;
        height: 38px;
        padding: 2px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .typography-setting .font-family-input {
        width: 100%;
    }
    
    .typography-setting .font-size-controls {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .font-size-device {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .font-size-device label {
        min-width: 70px;
        font-size: 0.875rem;
    }
    
    .font-size-device input {
        width: 70px;
    }
    
    .btn-save {
        margin-top: 1.5rem;
    }
    
    .section-divider {
        margin: 2rem 0;
        border-top: 1px solid #e9ecef;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .settings-tabs ul {
            flex-direction: column;
        }
        
        .settings-tabs a {
            border-radius: 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .settings-tabs a.active {
            border-bottom: 1px solid #0d6efd;
        }
        
        .setting-row {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .setting-col {
            min-width: 100%;
        }
        
        .font-size-group {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .font-size-group input {
            width: 100%;
        }
        
        .typography-settings-row {
            flex-direction: column;
        }
        
        .typography-setting {
            min-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Actions</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a class="dropdown-item" href="{{ route('settings.export') }}">Export Settings</a>
                    <form method="POST" action="{{ route('settings.import') }}" enctype="multipart/form-data" id="import-form" style="display: none;">
                        @csrf
                        <input type="file" name="settings_file" id="settings-file" accept=".json">
                    </form>
                    <a class="dropdown-item" href="#" onclick="document.getElementById('settings-file').click()">Import Settings</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    
    @if(session('success'))
    <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
        <div class="text-white">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <h6 class="mb-0 text-uppercase">System Settings</h6>
            <hr/>
            
            <!-- Settings Tabs Navigation -->
            <div class="settings-tabs">
                <ul>
                    <li><a href="#" data-tab="appearance-settings" class="active">Appearance</a></li>
                    <li><a href="#" data-tab="general-settings">General</a></li>
                    <li><a href="#" data-tab="contact-settings">Contact</a></li>
                    <li><a href="#" data-tab="social-settings">Social Media</a></li>
                    <li><a href="#" data-tab="custom-code-settings">Custom Code</a></li>
                </ul>
            </div>
            
            <!-- Settings Content -->
            <div class="settings-content">
                <!-- Appearance Settings -->
                <div id="appearance-settings" class="settings-section active">
                    <h2 class="settings-section-title">Appearance Settings</h2>
                    <p>Manage your site's appearance and styling options.</p>
                    
                    <form method="POST" action="{{ route('settings.appearance.update') }}">
                        @csrf
                        
                        <!-- Primary Colors -->
                        <div class="settings-subtitle">Primary Colors</div>
                        <div class="setting-row">
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Primary Color</label>
                                    <div class="color-setting">
                                        <input type="color" class="form-control" name="primary_color" value="{{ $settings['appearance']->where('key', 'primary_color')->first()?->value ?? '#333333' }}">
                                        <span>{{ $settings['appearance']->where('key', 'primary_color')->first()?->value ?? '#333333' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Secondary Color</label>
                                    <div class="color-setting">
                                        <input type="color" class="form-control" name="secondary_color" value="{{ $settings['appearance']->where('key', 'secondary_color')->first()?->value ?? '#ff5b2e' }}">
                                        <span>{{ $settings['appearance']->where('key', 'secondary_color')->first()?->value ?? '#ff5b2e' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Header Style -->
                        <div class="form-group">
                            <label class="form-label">Header Style</label>
                            <select class="form-select" name="header_style">
                                <option value="sticky" {{ ($settings['appearance']->where('key', 'header_style')->first()?->value ?? 'sticky') == 'sticky' ? 'selected' : '' }}>Sticky Header</option>
                                <option value="static" {{ ($settings['appearance']->where('key', 'header_style')->first()?->value ?? 'sticky') == 'static' ? 'selected' : '' }}>Static Header</option>
                            </select>
                        </div>
                        
                        <!-- Heading Settings -->
                        <div class="settings-subtitle">Heading Settings</div>
                        
                        <!-- H1 Settings -->
                        <div class="settings-subtitle">H1 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h1_color" value="{{ $settings['appearance']->where('key', 'h1_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h1_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h1_hover_color" value="{{ $settings['appearance']->where('key', 'h1_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h1_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h1_font_family" value="{{ $settings['appearance']->where('key', 'h1_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h1_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h1_font_size_desktop')->first()?->value ?? '32' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h1_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h1_font_size_tablet')->first()?->value ?? '28' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h1_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h1_font_size_mobile')->first()?->value ?? '24' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- H2 Settings -->
                        <div class="settings-subtitle">H2 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h2_color" value="{{ $settings['appearance']->where('key', 'h2_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h2_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h2_hover_color" value="{{ $settings['appearance']->where('key', 'h2_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h2_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h2_font_family" value="{{ $settings['appearance']->where('key', 'h2_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h2_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h2_font_size_desktop')->first()?->value ?? '28' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h2_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h2_font_size_tablet')->first()?->value ?? '24' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h2_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h2_font_size_mobile')->first()?->value ?? '20' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- H3 Settings -->
                        <div class="settings-subtitle">H3 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h3_color" value="{{ $settings['appearance']->where('key', 'h3_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h3_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h3_hover_color" value="{{ $settings['appearance']->where('key', 'h3_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h3_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h3_font_family" value="{{ $settings['appearance']->where('key', 'h3_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h3_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h3_font_size_desktop')->first()?->value ?? '24' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h3_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h3_font_size_tablet')->first()?->value ?? '20' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h3_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h3_font_size_mobile')->first()?->value ?? '18' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- H4 Settings -->
                        <div class="settings-subtitle">H4 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h4_color" value="{{ $settings['appearance']->where('key', 'h4_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h4_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h4_hover_color" value="{{ $settings['appearance']->where('key', 'h4_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h4_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h4_font_family" value="{{ $settings['appearance']->where('key', 'h4_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h4_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h4_font_size_desktop')->first()?->value ?? '20' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h4_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h4_font_size_tablet')->first()?->value ?? '18' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h4_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h4_font_size_mobile')->first()?->value ?? '16' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- H5 Settings -->
                        <div class="settings-subtitle">H5 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h5_color" value="{{ $settings['appearance']->where('key', 'h5_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h5_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h5_hover_color" value="{{ $settings['appearance']->where('key', 'h5_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h5_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h5_font_family" value="{{ $settings['appearance']->where('key', 'h5_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h5_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h5_font_size_desktop')->first()?->value ?? '18' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h5_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h5_font_size_tablet')->first()?->value ?? '16' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h5_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h5_font_size_mobile')->first()?->value ?? '14' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- H6 Settings -->
                        <div class="settings-subtitle">H6 Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h6_color" value="{{ $settings['appearance']->where('key', 'h6_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h6_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="h6_hover_color" value="{{ $settings['appearance']->where('key', 'h6_hover_color')->first()?->value ?? '#ff5b2e' }}">
                                    <span>{{ $settings['appearance']->where('key', 'h6_hover_color')->first()?->value ?? '#ff5b2e' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="h6_font_family" value="{{ $settings['appearance']->where('key', 'h6_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="h6_font_size_desktop" value="{{ $settings['appearance']->where('key', 'h6_font_size_desktop')->first()?->value ?? '16' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="h6_font_size_tablet" value="{{ $settings['appearance']->where('key', 'h6_font_size_tablet')->first()?->value ?? '14' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="h6_font_size_mobile" value="{{ $settings['appearance']->where('key', 'h6_font_size_mobile')->first()?->value ?? '12' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Paragraph Settings -->
                        <div class="settings-subtitle">Paragraph Settings</div>
                        <div class="typography-settings-row">
                            <div class="typography-setting">
                                <label class="form-label">Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="p_color" value="{{ $settings['appearance']->where('key', 'p_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'p_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Hover Color</label>
                                <div class="color-setting">
                                    <input type="color" class="form-control" name="p_hover_color" value="{{ $settings['appearance']->where('key', 'p_hover_color')->first()?->value ?? '#333333' }}">
                                    <span>{{ $settings['appearance']->where('key', 'p_hover_color')->first()?->value ?? '#333333' }}</span>
                                </div>
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Family</label>
                                <input type="text" class="form-control font-family-input" name="p_font_family" value="{{ $settings['appearance']->where('key', 'p_font_family')->first()?->value ?? 'Arial, sans-serif' }}" placeholder="e.g., Arial, sans-serif">
                            </div>
                            <div class="typography-setting">
                                <label class="form-label">Font Size</label>
                                <div class="font-size-controls">
                                    <div class="font-size-device">
                                        <label>Desktop:</label>
                                        <input type="number" class="form-control" name="p_font_size_desktop" value="{{ $settings['appearance']->where('key', 'p_font_size_desktop')->first()?->value ?? '16' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Tablet:</label>
                                        <input type="number" class="form-control" name="p_font_size_tablet" value="{{ $settings['appearance']->where('key', 'p_font_size_tablet')->first()?->value ?? '14' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                    <div class="font-size-device">
                                        <label>Mobile:</label>
                                        <input type="number" class="form-control" name="p_font_size_mobile" value="{{ $settings['appearance']->where('key', 'p_font_size_mobile')->first()?->value ?? '12' }}" min="1" max="100">
                                        <span>px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Link Color Options -->
                        <div class="settings-subtitle">Link Color Options</div>
                        <div class="setting-row">
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Link Color</label>
                                    <div class="color-setting">
                                        <input type="color" class="form-control" name="link_color" value="{{ $settings['appearance']->where('key', 'link_color')->first()?->value ?? '#0d6efd' }}">
                                        <span>{{ $settings['appearance']->where('key', 'link_color')->first()?->value ?? '#0d6efd' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Link Hover Color</label>
                                    <div class="color-setting">
                                        <input type="color" class="form-control" name="link_hover_color" value="{{ $settings['appearance']->where('key', 'link_hover_color')->first()?->value ?? '#0b5ed7' }}">
                                        <span>{{ $settings['appearance']->where('key', 'link_hover_color')->first()?->value ?? '#0b5ed7' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Custom CSS -->
                        <div class="form-group">
                            <label class="form-label">Custom CSS</label>
                            <textarea class="form-control" name="custom_css" rows="6" placeholder="Enter your custom CSS here...">{{ $settings['appearance']->where('key', 'custom_css')->first()?->value ?? '' }}</textarea>
                            <div class="form-text">Add your custom CSS here.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-save">Save Appearance Settings</button>
                    </form>
                </div>
                
                <!-- General Settings -->
                <div id="general-settings" class="settings-section">
                    <h2 class="settings-section-title">General Settings</h2>
                    <p>Manage your site's general information and branding.</p>
                    
                    <form method="POST" action="{{ route('settings.general.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="setting-row">
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Website Title</label>
                                    <input type="text" class="form-control" name="website_title" value="{{ $settings['general']->where('key', 'website_title')->first()?->value ?? 'E-Property' }}">
                                </div>
                            </div>
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Tagline</label>
                                    <input type="text" class="form-control" name="tagline" value="{{ $settings['general']->where('key', 'tagline')->first()?->value ?? 'Find Your property destiny' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="setting-row">
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Auto Logout Timeout (minutes)</label>
                                    <input type="number" class="form-control" name="auto_logout_timeout" value="{{ $settings['general']->where('key', 'auto_logout_timeout')->first()?->value ?? '30' }}" min="1" max="1440">
                                    <div class="form-text">Set the time (in minutes) after which inactive users will be automatically logged out. Set between 1 and 1440 minutes (24 hours).</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="setting-row">
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Logo</label>
                                    <input type="file" class="form-control" name="logo" accept="image/*">
                                    @if(isset($settings['general']) && $settings['general']->where('key', 'logo')->first()?->value)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings['general']->where('key', 'logo')->first()->value) }}" alt="Logo" style="max-height: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="setting-col">
                                <div class="form-group">
                                    <label class="form-label">Favicon</label>
                                    <input type="file" class="form-control" name="favicon" accept="image/*,.ico">
                                    @if(isset($settings['general']) && $settings['general']->where('key', 'favicon')->first()?->value)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings['general']->where('key', 'favicon')->first()->value) }}" alt="Favicon" style="max-height: 32px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-save">Save General Settings</button>
                    </form>
                </div>
                
                <!-- Contact Settings -->
                <div id="contact-settings" class="settings-section">
                    <h2 class="settings-section-title">Contact Settings</h2>
                    <p>Manage your business contact information.</p>
                    
                    <form method="POST" action="{{ route('settings.contact.update') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" value="{{ isset($settings['contact']) ? $settings['contact']->where('key', 'phone_number')->first()?->value : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email_address" value="{{ isset($settings['contact']) ? $settings['contact']->where('key', 'email_address')->first()?->value : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Physical Address</label>
                            <textarea class="form-control" name="physical_address" rows="3">{{ isset($settings['contact']) ? $settings['contact']->where('key', 'physical_address')->first()?->value : '' }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-save">Save Contact Settings</button>
                    </form>
                </div>
                
                <!-- Social Media Settings -->
                <div id="social-settings" class="settings-section">
                    <h2 class="settings-section-title">Social Media Settings</h2>
                    <p>Manage your social media profile links.</p>
                    
                    <form method="POST" action="{{ route('settings.social.update') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" class="form-control" name="facebook_url" value="{{ isset($settings['social']) ? $settings['social']->where('key', 'facebook_url')->first()?->value : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Twitter/X URL</label>
                            <input type="url" class="form-control" name="twitter_url" value="{{ isset($settings['social']) ? $settings['social']->where('key', 'twitter_url')->first()?->value : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" class="form-control" name="instagram_url" value="{{ isset($settings['social']) ? $settings['social']->where('key', 'instagram_url')->first()?->value : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="url" class="form-control" name="linkedin_url" value="{{ isset($settings['social']) ? $settings['social']->where('key', 'linkedin_url')->first()?->value : '' }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-save">Save Social Settings</button>
                    </form>
                </div>
                
                <!-- Custom Code Settings -->
                <div id="custom-code-settings" class="settings-section">
                    <h2 class="settings-section-title">Custom Code Settings</h2>
                    <p>Add custom code to the header or footer of your site.</p>
                    
                    <form method="POST" action="{{ route('settings.custom-code.update') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Header Code</label>
                            <textarea class="form-control" name="header_code" rows="5" placeholder="Analytics, meta tags, etc.">{{ isset($settings['custom_code']) ? $settings['custom_code']->where('key', 'header_code')->first()?->value : '' }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Footer Code</label>
                            <textarea class="form-control" name="footer_code" rows="5" placeholder="Chat widgets, tracking codes, etc.">{{ isset($settings['custom_code']) ? $settings['custom_code']->where('key', 'footer_code')->first()?->value : '' }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-save">Save Custom Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Import form handling
    document.getElementById('settings-file').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.getElementById('import-form').submit();
        }
    });
    
    // Update color value display
    document.querySelectorAll('input[type="color"]').forEach(function(colorInput) {
        colorInput.addEventListener('change', function() {
            const colorValue = this.value;
            const siblingSpan = this.parentNode.querySelector('span');
            if (siblingSpan) {
                siblingSpan.textContent = colorValue;
            }
        });
    });
    
    // Tab switching functionality
    document.querySelectorAll('.settings-tabs a').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get target tab
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and sections
            document.querySelectorAll('.settings-tabs a').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show target section
            document.getElementById(targetTab).classList.add('active');
            
            // Scroll to top of content
            document.querySelector('.settings-content').scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Update active tab based on hash in URL
    window.addEventListener('hashchange', function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const tabLink = document.querySelector(`.settings-tabs a[data-tab="${hash}"]`);
            if (tabLink) {
                tabLink.click();
            }
        }
    });
    
    // Check for hash on page load
    window.addEventListener('load', function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const tabLink = document.querySelector(`.settings-tabs a[data-tab="${hash}"]`);
            if (tabLink) {
                tabLink.click();
            }
        }
    });
</script>
@endsection