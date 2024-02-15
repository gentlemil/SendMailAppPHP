<div class="show">
    <?php $template = $params['template'] ?? null; ?>
    <?php if ($template) : ?>
    
    <ul>
        <li>
            Id: 
            <?php echo htmlentities($template['id']) ?>
        </li>
        <li>
            Title: 
            <?php echo htmlentities($template['title']) ?>
        </li>
        <li>
            Created: 
            <?php echo htmlentities($template['created']) ?>
        </li>
            <li>
            Message: 
            <?php echo htmlentities($template['message']) ?>
        </li>        
    </ul>

    <div class="flex-btn">
        <a href="/?action=edit&id=<?php echo $template['id'] ?>">
            <button>Select template</button>
        </a>

        <a href="/"><button>Main Page</button></a>
    </div>

    <?php else: ?>
        <p>No template to display</p>
    <?php endif; ?>
</div>
