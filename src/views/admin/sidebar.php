<div id="sidebar" class="bg-light border-end">
    <div class="p-3">
        <div class="d-flex flex-row align-items-center justify-content-center">
            <img style="width: 50px" src="<?php echo ROOT_URL . "/public/images/logo.png" ?>" class="header__web-logo" alt="logo">

            <div class="brandname d-flex flex-column">
                <span style="font-size: 20px;" class="header__brand-name">BEAUTY <span style="color: #e562c3">SKIN</span></span>
            </div>
        </div>
        <hr id="height-offset">
        
        <ul class="nav flex-column">
            <?php foreach (ADMIN_PANEL as $keySection => $sectionData): ?>
                <li class="nav-item mb-2">
                    <a href="<?php echo ROOT_URL . "/admin/$keySection/index"; ?>" 
                    class="nav-link sidebar-link <?php echo $current_section == $keySection ? 'active-section' : ''; ?>">
                        <i class="<?php echo $sectionData['icon']; ?>  fs-5 me-2"></i>
                        <span class="sidebar-text"><?php echo ucwords(str_replace('-', ' ', $keySection)); ?></span>
                    </a>
                    
                    <?php if (isset($sectionData['subsections']) && !empty($sectionData['subsections'])): ?>
                        <div class="collapse subsection <?php echo $current_section == $keySection ? 'show' : ''; ?>" 
                            id="<?php echo str_replace('-', '', $keySection); ?>">
                            <ul class="nav flex-column ms-3 mt-1">
                                <?php foreach ($sectionData['subsections'] as $subsectionData): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo ROOT_URL . "/admin/$keySection/{$subsectionData['url']}"; ?>" 
                                        class="nav-link sidebar-link <?php echo ($current_section == $keySection && $current_subsection == $subsectionData['url']) ? 'active-section' : ''; ?>">
                                            <i class="bi bi-circle<?php echo ($current_section == $keySection && $current_subsection == $subsectionData['url']) ? '-fill' : ''; ?> fs-5 me-2"></i>
                                            <span class="sidebar-text"><?php echo $subsectionData['name']; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>


    </div>
</div>