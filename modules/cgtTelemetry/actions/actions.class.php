<?php
class cgtTelemetryActions extends sfActions
{
	/**
	 * 
	 * @var array
	 */
	protected $forbiddenWords = array('CREATE', 'DELETE', 'DROP', 'INSERT', 'TRUNCATE', 'UPDATE');

	/**
	 * List available telemetry views
	 * 
	 * @param  sfWebRequest $request
	 */
	public function executeList(sfWebRequest $request)
	{
		$criteria = new Criteria();

		$criteria->clearSelectColumns();
		$criteria->addSelectColumn   (CgtTelemetryPeer::ID);
		$criteria->addSelectColumn   (CgtTelemetryPeer::NAME);
		$criteria->add               (CgtTelemetryPeer::ACTIVE, true);

		$stmt = CgtTelemetryPeer::doSelectStmt($criteria);

		$this->output = array(
			'result'  => 'OK',
			'message' => '',
			'data'    => $stmt->fetchAll(PDO::FETCH_ASSOC)
		);
	}

	/**
	 * Export a telemetry view
	 * 
	 * @param  sfWebRequest $request
	 * 
	 * @return null
	 * 
	 * @throws RuntimeException
	 */
	public function executeExport(sfWebRequest $request)
	{
		$id       = $request->getParameter('id');
		$callback = $request->getParameter('callback');

		// callback param available in template
		$this->callback = $callback;

		// Get object from db
		$cgtTelemetry = CgtTelemetryPeer::retrieveByPK($id);

		$this->forward404If(!$cgtTelemetry);
		$this->forward404If(!$cgtTelemetry->getActive());

		// Check if the SQL statement contains forbidden words
		$pattern = sprintf('/%s/i', implode('|', $this->forbiddenWords));
		$sql     = $cgtTelemetry->getSql();

		if (preg_match($pattern, $sql)) {
			throw new RuntimeException(sprintf('SQL query "%s" contains a forbidden word. Forbbiden words are: %s.', $sql, implode(', ', $this->forbiddenWords)));
		}

		// Init output
		$this->output = array(
			'result'  => '',
			'message' => '',
			'data'    => array(),
			'view'    => array(
				'id'   => $cgtTelemetry->getId(),
				'name' => $cgtTelemetry->getName(),
				'sql'  => $cgtTelemetry->getSql()
			)
		);

		// Execute SQL query
		try {
			$connection = Propel::getConnection(CgtTelemetryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
			$stmt       = $connection->query($sql);
		} catch (PDOException $e) {
			$this->output['result']  = 'KO';
			$this->output['message'] = $e->getMessage();

			return null;
		}

		// Handle result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		for ($i = 1; $i < 10; $i ++) {
			$graph              = new stdClass();

			$graph->axes        = new stdClass();
			$graph->axes->x     = array();
			$graph->axes->y     = array();
			$graph->axes->z     = array();

			$graph->labels      = new stdClass();
			$graph->labels->x   = null;
			$graph->labels->y   = 'Y label';
			$graph->labels->z   = null;

			$graph->coords      = new stdClass();
			$graph->coords->lat = array();
			$graph->coords->lon = array();
			
			foreach($result as $row) {
				if (!isset($row['x'])) {
					throw new RuntimeException('X axis not found.');
				}

				if (isset($row['x'])) {
					$graph->axes->x[] = $row['x'];
				} else {
					$graph->axes->x[] = $row[0];
				}

				if (isset($row['y' . $i])) {
					$graph->axes->y[] = $row['y' . $i];
				}

				if (isset($row['z' . $i])) {
					$graph->axes->z[] = $row['z' . $i];
				}

				if (isset($row['y' . $i . 'label'])) {
					$graph->labels->y = $row['y' . $i . 'label'];
				}

				if (isset($row['lat' . $i])) {
					$graph->coords->lat[] = $row['lat' . $i];
				}

				if (isset($row['lon' . $i])) {
					$graph->coords->lon[] = $row['lon' . $i];
				}
			}

			// Save graph data
			$this->output['data'][] = array(
				'x'    => $graph->axes->x,
				'y'    => $graph->axes->y,
				'z'    => $graph->axes->z,
				'name' => $graph->labels->y,
				'lat'  => $graph->coords->lat,
				'lon'  => $graph->coords->lon
			);
				
		}

		// Everything went fine
		$this->output['result'] = 'OK';
	}
}