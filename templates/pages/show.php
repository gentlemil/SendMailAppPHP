<div class="show">
    <?php $template = $params['template'] ?? null; ?>
    <?php if ($template) : ?>
    
    <ul>
        <li>
            <b>Id: </b><?php echo htmlentities($template['id']) ?>
        </li>
        
        <li style="width: 100%; display: flex; justify-content: space-between; padding-top: 5px">
            <div><b>Title: </b><?php echo htmlentities($template['title']) ?></div>
            <i style="opacity: 0.7;"><?php echo htmlentities($template['created']) ?></i>
        </li>
        
        <li style="padding-top: 10px;">
            <b>Message: </b>
            <br />
            <p style="text-align: justify;">
                <i><?php echo htmlentities($template['message']) ?></i>
            </p>
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
